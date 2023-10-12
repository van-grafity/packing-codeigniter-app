<?php

namespace App\Controllers;

use Config\Services;
use App\Models\PackingListModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;
use App\Models\SizeModel;
use App\Models\ProductModel;
use App\Models\PackinglistCartonModel;
use App\Models\CartonDetailModel;
use App\Models\StyleModel;

use CodeIgniter\I18n\Time;

class PackingList extends BaseController
{
    protected $PackingListModel;
    protected $BuyerModel;
    protected $PurchaseOrderModel;
    protected $SizeModel;
    protected $ProductModel;
    protected $PackinglistCartonModel;
    protected $CartonDetailModel;
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->PackingListModel = new PackingListModel();
        $this->BuyerModel = new BuyerModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->SizeModel = new SizeModel();
        $this->ProductModel = new ProductModel();
        $this->PackinglistCartonModel = new PackinglistCartonModel();
        $this->CartonDetailModel = new CartonDetailModel();
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title'         => 'Factory Packing List',
            'packinglist'   => $this->PackingListModel->getPackingList(),
            'po_list'       => $this->PurchaseOrderModel->getPurchaseOrder(),
        ];
        return view('packinglist/index', $data);
    }

    public function store()
    {
        $request_data = $this->request->getPost();

        $month_filter = date('m');
        $year_filter = date('Y');
        $packinglist_this_month = $this->PackingListModel->getLastPackinglistByMonth($year_filter, $month_filter);
        $next_packinglist_number = $packinglist_this_month ? $packinglist_this_month->packinglist_number + 1 : 1;
        $next_packinglist_serial_number = $this->generate_serial_number($next_packinglist_number);

        $packinglist_data = [
            'packinglist_number' => $next_packinglist_number,
            'packinglist_serial_number' => $next_packinglist_serial_number,
            'packinglist_date' => $this->request->getPost('packinglist_date'),
            'packinglist_po_id' => $this->request->getPost('po_no'),
            'packinglist_qty' => $this->request->getPost('order_qty'),
            'destination' => $this->request->getPost('destination'),
            'department' => $this->request->getPost('department'),
        ];

        $packing_id = $this->PackingListModel->insert($packinglist_data);
        return redirect()->to('packinglist');
    }

    public function update()
    {
        $packinglist_data = [
            'packinglist_po_id' => $this->request->getPost('po_no'),
            'packinglist_qty' => $this->request->getPost('order_qty'),
            'destination' => $this->request->getPost('destination'),
            'department' => $this->request->getPost('department'),
        ];
        $id = $this->request->getPost('edit_packinglist_id');
        $this->PackingListModel->update($id, $packinglist_data);
        return redirect()->to('packinglist');
    }

    public function delete()
    {
        $id = $this->request->getPost('packinglist_id');
        $delete = $this->PackingListModel->delete($id);
        return redirect()->to('packinglist');
    }

    public function detail($id)
    {
        $packinglist_carton = $this->PackinglistCartonModel->getDataByPackinglist($id);
        $packinglist_size_list = $this->PackingListModel->getSizeList($id);
        $packinglist_carton_data = [];

        foreach ($packinglist_carton as $key => $carton) {
            $products_in_carton = $this->PackinglistCartonModel->getProductsInCarton($carton->id);

            foreach ($products_in_carton as $key => $product) {
                $product_ratio_by_size_list = [];
                foreach ($packinglist_size_list as $key_size => $size) {
                    $ratio_per_size = (object)[
                        'size_id' => $size->id,
                        'size_size' => $size->size,
                    ];
                    if ($product->size_id == $size->id) {
                        $ratio_per_size->size_qty = $product->product_qty;
                    } else {
                        $ratio_per_size->size_qty = '';
                    }

                    $product_ratio_by_size_list[] =  $ratio_per_size;
                }
                $products_in_carton[$key]->ratio_by_size_list = $product_ratio_by_size_list;
            }

            $packinglist_carton_data[] = (object)[
                'id' => $carton->id,
                'carton_number_from' => $carton->carton_number_from,
                'carton_number_to' => $carton->carton_number_to,
                'pcs_per_carton' => $carton->pcs_per_carton,
                'carton_qty' => $carton->carton_qty,
                'ship_qty' => $carton->pcs_per_carton * $carton->carton_qty,
                'products_in_carton' => $products_in_carton,
                'number_of_product_per_carton' => count($products_in_carton),
                'gross_weight' => $carton->gross_weight,
                'net_weight' => $carton->net_weight,
            ];
        }

        $packinglist = $this->PackingListModel->getPackingList($id);
        $packinglist->total_carton = $this->PackingListModel->getTotalCarton($id);
        $packinglist->percentage_ship = $this->PackingListModel->getShipmentPercentage($id);

        $style_by_po = $this->StyleModel->getStyleByPO($packinglist->packinglist_po_id);
        $packinglist->style_no = implode(' | ', (array_column($style_by_po, 'style_no')));
        $packinglist->style_description = implode(' | ', (array_column($style_by_po, 'style_description')));

        $data = [
            'title'         => 'Packing List Detail',
            'packinglist'   => $packinglist,
            'products'   => $this->ProductModel->getByPurchaseOrderID($packinglist->po_id),
            'packinglist_carton'   => $packinglist_carton_data,
            'packinglist_size_list'   => $packinglist_size_list,
            'size_colspan'   => count($packinglist_size_list),
            'size_rowspan'   => count($packinglist_size_list) ?  1 : 2,
        ];

        return view('packinglist/detail', $data);
    }

    public function cartonstore()
    {
        $packinglist_id = $this->request->getPost('packinglist_id');
        $products_in_carton = $this->request->getPost('products_in_carton');
        $products_in_carton_qty = $this->request->getPost('products_in_carton_qty');
        try {
            $this->PackinglistCartonModel->transException(true)->transStart();

            $packinglist_carton_data = [
                'packinglist_id' => $this->request->getPost('packinglist_id'),
                'carton_qty' => $this->request->getPost('carton_qty'),
                'gross_weight' => $this->request->getPost('gross_weight'),
                'net_weight' => $this->request->getPost('net_weight'),
                'carton_number_from' => $this->request->getPost('carton_number_from'),
                'carton_number_to' => $this->request->getPost('carton_number_to'),
                'measurement_ctn' => $this->request->getPost('measurement_ctn'),
            ];
            $packinglist_carton_id = $this->PackinglistCartonModel->insert($packinglist_carton_data);

            if ($products_in_carton) {
                foreach ($products_in_carton as $key => $product_id) {
                    $carton_detail_data = [
                        'packinglist_carton_id' => $packinglist_carton_id,
                        'product_id' => $product_id,
                        'product_qty' => $products_in_carton_qty[$key],
                    ];
                    $this->CartonDetailModel->insert($carton_detail_data);
                }
            }

            $sync_prosses = $this->PackingListModel->syncWithPackinglistCarton($packinglist_id);
            $this->PackinglistCartonModel->transComplete();
        } catch (DatabaseException $e) {
            // Automatically rolled back already.

        }
        return redirect()->to('packinglist/' . $packinglist_id);
    }

    public function cartonedit()
    {
        $id = $this->request->getGet('id');
        $packinglist_carton = $this->PackinglistCartonModel->find($id);
        $carton_detail = $this->PackinglistCartonModel->getProductsInCarton($id);

        $data_return = [
            'status' => 'success',
            'message' => 'successfully get data carton',
            'data' => [
                'packinglist_carton' => $packinglist_carton,
                'carton_detail' => $carton_detail,
            ],
        ];
        return $this->response->setJSON($data_return);
    }

    public function cartonupdate()
    {
        $packinglist_carton_id = $this->request->getPost('edit_packinglist_carton_id');

        $packinglist_id = $this->request->getPost('packinglist_id');
        $products_in_carton = $this->request->getPost('products_in_carton');
        $products_in_carton_qty = $this->request->getPost('products_in_carton_qty');

        try {
            $this->PackinglistCartonModel->transException(true)->transStart();

            $packinglist_carton_data = [
                'packinglist_id' => $this->request->getPost('packinglist_id'),
                'carton_qty' => $this->request->getPost('carton_qty'),
                'gross_weight' => $this->request->getPost('gross_weight'),
                'net_weight' => $this->request->getPost('net_weight'),
                'carton_number_from' => $this->request->getPost('carton_number_from'),
                'carton_number_to' => $this->request->getPost('carton_number_to'),
                'measurement_ctn' => $this->request->getPost('measurement_ctn'),
            ];
            $this->PackinglistCartonModel->update($packinglist_carton_id, $packinglist_carton_data);

            $this->CartonDetailModel->where('packinglist_carton_id', $packinglist_carton_id)->delete();
            if ($products_in_carton) {
                foreach ($products_in_carton as $key => $product_id) {
                    $carton_detail_data = [
                        'packinglist_carton_id' => $packinglist_carton_id,
                        'product_id' => $product_id,
                        'product_qty' => $products_in_carton_qty[$key],
                    ];
                    $this->CartonDetailModel->insert($carton_detail_data);
                }
            }
            $sync_prosses = $this->PackingListModel->syncWithPackinglistCarton($packinglist_id);
            $this->PackinglistCartonModel->transComplete();
        } catch (DatabaseException $e) {
            // Automatically rolled back already.

        }
        return redirect()->to('packinglist/' . $packinglist_id);
    }

    public function cartondelete()
    {
        $id = $this->request->getPost('packinglist_carton_id');
        $packinglist_id = $this->request->getPost('packinglist_id');

        // ## Before Deleting Packinglist, must delete carton_detail first 
        $delete_carton_detail = $this->CartonDetailModel->where('packinglist_carton_id',$id)->delete();

        $delete = $this->PackinglistCartonModel->delete($id);
        $sync_prosses = $this->PackingListModel->syncWithPackinglistCarton($packinglist_id);

        $sync_prosses = $this->PackingListModel->syncWithPackinglistCarton($packinglist_id);
        return redirect()->to('packinglist/' . $packinglist_id);
    }

    private function generate_serial_number($number)
    {
        $serial_number = 'PL-' . date('ym') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        return $serial_number;
    }

    public function report($id)
    {
        $packinglist_carton = $this->PackinglistCartonModel->getDataByPackinglist($id);
        $packinglist_size_list = $this->PackingListModel->getSizeList($id);
        $packinglist_carton_data = [];
        $packinglist_carton_total_data = (object)[
            'total_carton' => 0,
            'total_ship' => 0,
        ];

        foreach ($packinglist_carton as $key => $carton) {
            $products_in_carton = $this->PackinglistCartonModel->getProductsInCarton($carton->id);
            
            foreach ($products_in_carton as $key_product => $product) {
                $product_ratio_by_size_list = [];
                foreach ($packinglist_size_list as $key_size => $size) {
                    $ratio_per_size = (object)[
                        'size_id' => $size->id,
                        'size_size' => $size->size,
                    ];
                    if ($product->size_id == $size->id) {
                        $ratio_per_size->size_qty = $product->product_qty;
                    } else {
                        $ratio_per_size->size_qty = '';
                    }

                    $product_ratio_by_size_list[] =  $ratio_per_size;
                }
                $products_in_carton[$key_product]->ratio_by_size_list = $product_ratio_by_size_list;
            }

            $packinglist_carton_data[] = (object)[
                'id' => $carton->id,
                'carton_number_from' => $carton->carton_number_from,
                'carton_number_to' => $carton->carton_number_to,
                'pcs_per_carton' => $carton->pcs_per_carton,
                'carton_qty' => $carton->carton_qty,
                'ship_qty' => $carton->pcs_per_carton * $carton->carton_qty,
                'products_in_carton' => $products_in_carton,
                'number_of_product_per_carton' => count($products_in_carton),
                'gross_weight' => $carton->gross_weight,
                'net_weight' => $carton->net_weight,
                'gross_weight_lbs' => round($carton->gross_weight * 2.20462, 2),
                'net_weight_lbs' => round($carton->net_weight * 2.20462, 2),
                'measurement_ctn' => $carton->measurement_ctn,
            ];

            $packinglist_carton_total_data->total_carton += $packinglist_carton_data[$key]->carton_qty;
            $packinglist_carton_total_data->total_ship += $packinglist_carton_data[$key]->ship_qty;
        }

        $packinglist = $this->PackingListModel->getPackingList($id);
        $packinglist->total_carton = $this->PackingListModel->getTotalCarton($id);
        $packinglist->percentage_ship = $this->PackingListModel->getShipmentPercentage($id);
        $packinglist->contract_qty = $this->PackingListModel->getContractQty($id);

        $style_by_po = $this->StyleModel->getStyleByPO($packinglist->packinglist_po_id);
        $packinglist->style_no = implode(' | ', (array_column($style_by_po, 'style_no')));
        $packinglist->style_description = implode(' | ', (array_column($style_by_po, 'style_description')));


        //## Get Shipment Percentage per UPC
        $shipment_percentage_each_upc = $this->PackingListModel->getShipmentPercentageEachProduct($id);
        $contract_qty_each_product = $this->PackingListModel->getContractQtyEachProduct($id);

        foreach ($shipment_percentage_each_upc as $key => $product) {
            $product_id = $product->product_id;
            $po_qty = $this->searchInArrayByProductID($product_id, $contract_qty_each_product)['po_qty'];
            $shipment_percentage_each_upc[$key]->po_qty = $po_qty;
            $shipment_percentage_each_upc[$key]->percentage = round($product->shipment_qty / $po_qty * 100) . '%';
        }


        // ## sparate to 2 array if upc more than 4. for better layout on form packinglist
        $count_all_shipment_upc = count($shipment_percentage_each_upc);
        $shipment_percentage_each_upc_part1 = [];
        $shipment_percentage_each_upc_part2 = [];
        if($count_all_shipment_upc > 4) {
            $row_in_one_column = $count_all_shipment_upc /2;
            foreach ($shipment_percentage_each_upc as $key => $upc) {
                if($key < $row_in_one_column) {
                    $shipment_percentage_each_upc_part1[] = $upc;
                } else {
                    $shipment_percentage_each_upc_part2[] = $upc;
                }
            }
        } else {
            $shipment_percentage_each_upc_part1 = $shipment_percentage_each_upc;
        }


        $date_printed = new Time('now');
        $date_printed = $date_printed->toLocalizedString('eeee, dd-MMMM-yyyy HH:mm');
        
        $asin_style = 'display: none';
        $buyer = $this->PackingListModel->getBuyerByPackinglistId($id);
        if($buyer->buyer_name == 'AMAZON') {
            $asin_style = '';
        }
        
        $filename = 'Factory Packing List - ('. $packinglist->packinglist_serial_number .') - PO#' . $packinglist->po_no;
        $data = [
            'title'         => $filename,
            'packinglist'   => $packinglist,
            'products'   => $this->ProductModel->getByPurchaseOrderID($packinglist->po_id),
            'packinglist_carton'   => $packinglist_carton_data,
            'packinglist_carton_total'   => $packinglist_carton_total_data,
            'packinglist_size_list'   => $packinglist_size_list,
            'shipment_percentage_each_upc'   => $shipment_percentage_each_upc,
            'shipment_percentage_each_upc_part1'   => $shipment_percentage_each_upc_part1,
            'shipment_percentage_each_upc_part2'   => $shipment_percentage_each_upc_part2,
            'size_colspan'   => count($packinglist_size_list),
            'size_rowspan'   => count($packinglist_size_list) ?  1 : 2,
            'date_printed' => $date_printed,
            'asin_style' => $asin_style,
        ];

        // return view('report/packinglist_pdf', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/packinglist_pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    public function htmlToPDF(){
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('pdf_view'));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->set_option('defaultMediaType', 'all');
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->render();
        $dompdf->stream();
    }

    private function searchInArrayByProductID(String $product_id, Array $array_po) : Array
    {
        foreach ($array_po as $key => $product) {
            if(isset($product->product_id) && $product->product_id == $product_id){
                return (array)$product;
            }
        }
        return [];
    }

}
