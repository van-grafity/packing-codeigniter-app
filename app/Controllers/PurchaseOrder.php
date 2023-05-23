<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $PurchaseOrderModel;

    public function __construct()
    {
        $this->PurchaseOrderModel = new PurchaseOrderModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyer'     => $this->PurchaseOrderModel->getBuyer()->getResult(),
            'gl'        => $this->PurchaseOrderModel->getGL()->getResult(),
            'buyerPO'   => $this->PurchaseOrderModel->getPO()->getResult(),
            'Product'   => $this->PurchaseOrderModel->getPoduct()->getResult(),
            'Sizes'     => $this->PurchaseOrderModel->getSize()->getResult(),
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
            'buyerPO'   => $this->PurchaseOrderModel->getPO()->getResult(),
        ];
        // dd($buyerPO);
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
