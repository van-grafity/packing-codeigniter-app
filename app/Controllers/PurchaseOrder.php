<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderStyleModel;
use App\Models\PurchaseOrderSizeModel;
use App\Models\GlModel;
use App\Models\FactoryModel;

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
        $this->GlModel = new GlModel();
        $this->FactoryModel = new FactoryModel();
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
            'gl'        => $this->GlModel->findAll(),
            'factory'   => $this->FactoryModel->findAll(),
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

    public function store(){
        // dd($this->request->getVar());
        // validation
        if (!$this->validate([
            'PO_No' => [
                'rules' => 'required|is_unique[tblpurchaseorder.PO_No]',
                'errors' => [
                    'required' => '{field} is required',
                    'is_unique' => '{field} already exists'
                ]
            ],
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required'
                ]
            ],
            'shipdate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required'
                ]
            ],
            'unit_price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required'
                ]
            ],
            'PO_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required'
                ]
            ],
            'PO_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required'
                ]
            ]
        ])) {
            return redirect()->to('/purchaseorder')->withInput();
        }

        $this->PurchaseOrderModel->save([
            'PO_No' => $this->request->getVar('PO_No'),
            'gl_id' => $this->request->getVar('id'),
            'factory_id' => $this->request->getVar('id'),
            'shipdate' => $this->request->getVar('shipdate'),
            'unit_price' => $this->request->getVar('unit_price'),
            'PO_qty' => $this->request->getVar('PO_qty'),
            'PO_amount' => $this->request->getVar('PO_amount')
        ]);

        session()->setFlashdata('message', 'Added Successfully!');
        return redirect()->to('/purchaseorder');
    }
}
