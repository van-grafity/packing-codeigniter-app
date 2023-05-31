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
        // dd($data);
        // return view('PL/index', $data);
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
        ];
        
        $packing_id = $this->PackingListModel->insert($packinglist_data);
        return redirect()->to('packinglist');
    }

    public function update() {
        $packinglist_data = [
            'packinglist_po_id' => $this->request->getPost('po_no'),
            'packinglist_qty' => $this->request->getPost('order_qty'),
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
        // $packinglist_carton = $this->PackinglistCartonModel->where('packinglist_id',$id)->find();
        $packinglist_carton = $this->PackinglistCartonModel->getDataByPackinglist($id);
        $packinglist_size_list = $this->PackingListModel->getSizeList($id);

        // dd($packinglist_size_list);
        
        // $packinglist_carton = $this->PackinglistCartonModel->getDataByPackinglist($id);
        // dd($packinglist_carton);
        $packinglist_carton_data = [];

        foreach ($packinglist_carton as $key => $carton) {
            // $products_in_carton = $this->CartonDetailModel->where('packinglist_carton_id', $carton->id)->find();
            // $packinglist_carton_data[] = [
            //     'products_in_carton' => $products_in_carton,
            // ];
            $products_in_carton = $this->PackinglistCartonModel->getProductsInCarton($carton->id);
            // dd($products_in_carton);
            
            $packinglist_carton_data[] = (object)[
                'carton_number_from' => $carton->carton_number_from,
                'carton_number_to' => $carton->carton_number_to,
                'colour' => $carton->colour,
                'pcs_per_carton' => $carton->pcs_per_carton,
                'carton_qty' => $carton->carton_qty,
                'ship_qty' => $carton->pcs_per_carton * $carton->carton_qty,
                'products_in_carton' => $products_in_carton,
                'gross_weight' => $carton->gross_weight,
                'net_weight' => $carton->net_weight,
            ];
        }

        // dd($packinglist_carton_data);
        
        $data = [
            'title'         => 'Packing List Detail',
            'packinglist'   => $this->PackingListModel->getPackingList($id),
            'products'   => $this->ProductModel->getByPackinglist($id),
            'packinglist_carton'   => $packinglist_carton_data,
        ];
        return view('packinglist/detail', $data);
    }

    public function cartonstore()
    {
        // dd($this->request->getPost());
        $packinglist_id = $this->request->getPost('packinglist_id');
        $products_in_carton = $this->request->getPost('products_in_carton');
        $products_in_carton_qty = $this->request->getPost('products_in_carton_qty');
        try {
            $this->PurchaseOrderModel->transException(true)->transStart();

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

            $this->PurchaseOrderModel->transComplete();
        } catch (DatabaseException $e) {
            // Automatically rolled back already.
        }

        return redirect()->to('packinglist/'.$packinglist_id);
    }

    private function generate_serial_number($number)
    {
        $serial_number = 'PL-'. date('ym') . '-' . str_pad($number, 3, '0',STR_PAD_LEFT);
        return $serial_number;
    }
}
