<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderStyleModel;
use App\Models\PurchaseOrderSizeModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $PurchaseOrderModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->PurchaseOrderStyleModel = new PurchaseOrderStyleModel();
        $this->PurchaseOrderSizeModel = new PurchaseOrderSizeModel();
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

    public function detail($PO_No)
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->PurchaseOrderModel->select('tblpurchaseorder.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name, tblfactory.name as factory_name')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id')
                ->where('tblpurchaseorder.PO_No', $PO_No)
                ->first(),
            'purchaseorderstyle'  => $this->PurchaseOrderStyleModel->select('tblpurchaseorderstyle.*, tblstyles.style_description, tblstyles.style_no')
                ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
                ->where('tblpurchaseorderstyle.purchase_order_id', $this->PurchaseOrderModel->select('tblpurchaseorder.id')
                    ->where('tblpurchaseorder.PO_No', $PO_No)
                    ->first()['id'])
                ->findAll(),
            'purchaseordersize'  => $this->PurchaseOrderSizeModel->select('tblpurchaseordersize.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpurchaseordersize.size_id')
                ->where('tblpurchaseordersize.purchase_order_id', $this->PurchaseOrderModel->select('tblpurchaseorder.id')
                    ->where('tblpurchaseorder.PO_No', $PO_No)
                    ->first()['id'])
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('purchaseorder/detail', $data);
    }
}
