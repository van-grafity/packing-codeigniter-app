<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\GLModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $PurchaseOrderModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->PurchaseOrderModel = new PurchaseOrderModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->PurchaseOrderModel->select('tblpurchaseorder.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name, tblfactory.name as factory_name')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id')
                ->findAll(),
            'validation' => \Config\Services::validation()

        ];

        return view('purchaseorder/index', $data);
    }
}
