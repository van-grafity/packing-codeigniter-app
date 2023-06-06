<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;
use App\Models\SizeModel;
use App\Models\ProductModel;
use App\Models\PackinglistCartonModel;
use App\Models\CartonDetailModel;

helper('number', 'form', 'url', 'text');

class PackingList extends BaseController
{
    protected $PackingListModel;
    protected $BuyerModel;
    protected $PurchaseOrderModel;
    protected $SizeModel;
    protected $ProductModel;
    protected $PackinglistCartonModel;
    protected $CartonDetailModel;

    public function __construct()
    {
        $this->PackingListModel = new PackingListModel();
        $this->BuyerModel = new BuyerModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->SizeModel = new SizeModel();
        $this->ProductModel = new ProductModel();
        $this->PackinglistCartonModel = new PackinglistCartonModel();
        $this->CartonDetailModel = new CartonDetailModel();
    }

    public function index()
    {
        $data = [
            'title'         => 'Factory Packing List',
            'PackingList'   => $this->PackingListModel->getPackingList(),
            'po_list'       => $this->PurchaseOrderModel->getPO()->getResult(),

        ];
        return view('packinglist/index', $data);
    }

    public function store()
    {
        $request_data = $this->request->getPost();
        
        $month_filter = date('m');
        $packinglist_this_month = $this->PackingListModel->get_last_pl_by_month($month_filter);
        $next_packinglist_number = $packinglist_this_month->packinglist_number + 1;
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
        $this->PackingListModel->update($id,$packinglist_data);
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
                    if($product->size_id == $size->id){
                        $ratio_per_size->size_qty = $product->product_qty;
                    } else {
                        $ratio_per_size->size_qty = 0;
                    }

                    $product_ratio_by_size_list[] =  $ratio_per_size;
                }
                $products_in_carton[$key]->ratio_by_size_list = $product_ratio_by_size_list;
            }
            
            $packinglist_carton_data[] = (object)[
                'id' => $carton->id,
                'carton_number_from' => $carton->carton_number_from,
                'carton_number_to' => $carton->carton_number_to,
                'colour' => $carton->colour,
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
        $packinglist->total_carton = $this->PackingListModel->get_total_carton($id);
        $packinglist->percentage_ship = $this->PackingListModel->get_percentage_ship($id);
        
        $data = [
            'title'         => 'Packing List Detail',
            'packinglist'   => $packinglist,
            'products'   => $this->ProductModel->getByPackinglist($id),
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
    
            $sync_prosses = $this->PackingListModel->sync_with_packinglist_carton($packinglist_id);
            $this->PackinglistCartonModel->transComplete();
        } catch (DatabaseException $e) {
            // Automatically rolled back already.

        }
        return redirect()->to('packinglist/'.$packinglist_id);
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
            ];
            $this->PackinglistCartonModel->update($packinglist_carton_id,$packinglist_carton_data);
            
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
            $sync_prosses = $this->PackingListModel->sync_with_packinglist_carton($packinglist_id);
            $this->PackinglistCartonModel->transComplete();
        } catch (DatabaseException $e) {
            // Automatically rolled back already.

        }
        return redirect()->to('packinglist/'.$packinglist_id);
    }
    
    public function cartondelete() 
    {
        $id = $this->request->getPost('packinglist_carton_id');
        $packinglist_id = $this->request->getPost('packinglist_id');

        $delete = $this->PackinglistCartonModel->delete($id);
        $sync_prosses = $this->PackingListModel->sync_with_packinglist_carton($packinglist_id);

        $sync_prosses = $this->PackingListModel->sync_with_packinglist_carton($packinglist_id);
        return redirect()->to('packinglist/'. $packinglist_id);
    }

    private function generate_serial_number($number)
    {
        $serial_number = 'PL-'. date('ym') . '-' . str_pad($number, 3, '0',STR_PAD_LEFT);
        return $serial_number;
    }
}
