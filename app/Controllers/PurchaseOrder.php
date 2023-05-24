<?php

namespace App\Controllers;

use App\Models\BuyerModel;
use App\Models\GLModel;
use App\Models\PurchaseOrderModel;
use App\Models\ProductModel;
use App\Models\SizeModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $BuyerModel;
    protected $GLModel;
    protected $PurchaseOrderModel;
    protected $ProductModel;
    protected $SizeModel;

    public function __construct()
    {
        $this->BuyerModel = new BuyerModel();
        $this->GLModel = new GLModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->ProductModel = new ProductModel();
        $this->SizeModel = new SizeModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'Buyer'     => $this->BuyerModel->getBuyer()->getResult(),
            'GL'        => $this->GLModel->getGL()->getResult(),
            'BuyerPO'   => $this->PurchaseOrderModel->getPO()->getResult(),
            'Product'   => $this->ProductModel->getProduct()->getResult(),
            'Sizes'     => $this->SizeModel->getSize()->getResult(),
        ];
        // dd($data['Product']);
        return view('purchaseorder/index', $data);
    }

    public function savePO()
    {
        $data = array(
            'id'           => $this->request->getVar('id'),
            'PO_No'        => $this->request->getVar('PO_No'),
            'gl_id'        => $this->request->getVar('gl_no'),
            'shipdate'     => $this->request->getVar('shipdate'),
            'PO_qty'       => $this->request->getVar('PO_qty'),
            'PO_amount'    => $this->request->getVar('PO_amount'),
        );

        $this->PurchaseOrderModel->savePO($data);
        return redirect()->to('/purchaseorder');
    }

    public function detail()
    {
        $data = [
            'title'     => 'Purchase Order Detail',
            'buyerPO'   => $this->PurchaseOrderModel->getPOdetails()->getResult(),
        ];
        return view('purchaseorder/detail', $data);
    }

    public function updatePO()
    {
        $id = $this->request->getVar('id');
        $data = array(
            'id'           => $this->request->getVar('id'),
            'PO_No'        => $this->request->getVar('PO_No'),
            'gl_id'        => $this->request->getVar('gl_no'),
            'shipdate'     => $this->request->getVar('shipdate'),
            'PO_qty'       => $this->request->getVar('PO_qty'),
            'PO_amount'    => $this->request->getVar('PO_amount'),
        );
        $this->PurchaseOrderModel->updateStyle($data, $id);
        return redirect()->to('/purchaseorder');
    }

    public function delete()
    {
        $id = $this->request->getVar('PO_id');
        $this->PurchaseOrderModel->deletePO($id);
        return redirect()->to('purchaseorder');
    }
}
