<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;
use App\Models\SizeModel;
use App\Models\ProductModel;

helper('number', 'form', 'url', 'text');

class PackingList extends BaseController
{
    protected $PackingListModel;
    protected $BuyerModel;
    protected $PurchaseOrderModel;
    protected $SizeModel;
    protected $ProductModel;

    public function __construct()
    {
        $this->PackingListModel = new PackingListModel();
        $this->BuyerModel = new BuyerModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->SizeModel = new SizeModel();
        $this->ProductModel = new ProductModel();
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

    public function detail($id)
    {
        $data = [
            'title'         => 'Packing List Detail',
            'packinglist'   => $this->PackingListModel->getPackingList($id),
            'products'   => $this->ProductModel->getByPackinglist($id),
        ];
        // dd($data);
        return view('packinglist/detail', $data);
    }

    public function delete()
    {
        $id = $this->request->getPost('packinglist_id');
        $delete = $this->PackingListModel->delete($id);
        return redirect()->to('packinglist');
    }

    public function cartonstore()
    {
        dd($this->request->getPost());
        dd("masuk");
        
    }

    private function generate_serial_number($number)
    {
        $serial_number = 'PL-'. date('ym') . '-' . str_pad($number, 3, '0',STR_PAD_LEFT);
        return $serial_number;
    }
}
