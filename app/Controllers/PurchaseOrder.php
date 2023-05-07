<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderDetailModel;
use App\Models\PurchaseOrderStyleModel;
use App\Models\PurchaseOrderSizeModel;
use App\Models\GlModel;
use App\Models\FactoryModel;
use App\Models\StyleModel;
use App\Models\PackingListSizeModel;
use App\Models\SizeModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $PurchaseOrderModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->purchaseOrderModel = new PurchaseOrderModel();
        $this->purchaseOrderDetailModel = new PurchaseOrderDetailModel();
        $this->purchaseOrderStyleModel = new PurchaseOrderStyleModel();
        $this->purchaseOrderSizeModel = new PurchaseOrderSizeModel();

        $this->packingListSizeModel = new PackingListSizeModel();

        $this->glModel = new GlModel();
        $this->factoryModel = new FactoryModel();
        $this->styleModel = new StyleModel();
        $this->sizeModel = new SizeModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->purchaseOrderModel->select('tblpurchaseorder.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name, tblfactory.name as factory_name')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id')
                ->findAll(),
            'gl'        => $this->glModel->findAll(),
            'factory'   => $this->factoryModel->findAll(),
            'purchaseordersize'  => $this->purchaseOrderSizeModel->select('tblpurchaseordersize.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpurchaseordersize.size_id')
                ->findAll(),
            'purchaseorderstyle'  => $this->purchaseOrderStyleModel->select('tblpurchaseorderstyle.*, tblstyles.style_description, tblstyles.style_no')
                ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
                ->findAll(),
            'size'  => $this->sizeModel->findAll(),
            'style'  => $this->styleModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('purchaseorder/index', $data);
    }

    public function detail($PO_No)
    {
        // $buyerPO = $this->purchaseOrderModel->select('tblpurchaseorder.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name, tblfactory.name as factory_name')
        //     ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
        //     ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
        //     ->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id')
        //     ->findAll();
            
        // // get data size and style by purchase order
        // $data = [];
        // foreach ($buyerPO as $po) {
        //     $data[] = [
        //         'id' => $po->id,
        //         'PO_No' => $po->PO_No,
        //         'gl_number' => $po->gl_number,
        //         'season' => $po->season,
        //         'size_order' => $po->size_order,
        //         'buyer_name' => $po->buyer_name,
        //         'factory_name' => $po->factory_name,
        //         'shipdate' => $po->shipdate,
        //         'unit_price' => $po->unit_price,
        //         'PO_qty' => $po->PO_qty,
        //         'PO_amount' => $po->PO_amount,
        //         'style' => $this->purchaseOrderStyleModel->select('tblpurchaseorderstyle.*, tblstyles.style_description, tblstyles.style_no')
        //             ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
        //             ->where('tblpurchaseorderstyle.purchase_order_id', $po->id)
        //             ->findAll(),
        //         'size' => $this->purchaseOrderSizeModel->select('tblpurchaseordersize.*, tblsizes.size')
        //             ->join('tblsizes', 'tblsizes.id = tblpurchaseordersize.size_id')
        //             ->where('tblpurchaseordersize.purchase_order_id', $po->id)
        //             ->findAll(),
        //     ];
        // }

        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->purchaseOrderModel->select('tblpurchaseorder.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name, tblfactory.name as factory_name')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id')
                ->where('tblpurchaseorder.PO_No', $PO_No)
                ->first(),
            'purchaseorderstyle'  => $this->purchaseOrderStyleModel->select('tblpurchaseorderstyle.*, tblstyles.style_description, tblstyles.style_no')
                ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
                ->where('tblpurchaseorderstyle.purchase_order_id', $this->purchaseOrderModel->select('tblpurchaseorder.id')
                    ->where('tblpurchaseorder.PO_No', $PO_No)
                    ->first()->id)
                ->findAll(),
            'purchaseordersize'  => $this->purchaseOrderSizeModel->select('tblpurchaseordersize.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpurchaseordersize.size_id')
                ->where('tblpurchaseordersize.purchase_order_id', $this->purchaseOrderModel->select('tblpurchaseorder.id')
                    ->where('tblpurchaseorder.PO_No', $PO_No)
                    ->first()->id)
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

        $this->purchaseOrderModel->save([
            'PO_No' => $this->request->getVar('PO_No'),
            'gl_id' => $this->request->getVar('id'),
            'factory_id' => $this->request->getVar('id'),
            'shipdate' => $this->request->getVar('shipdate'),
            'unit_price' => $this->request->getVar('unit_price'),
            'PO_qty' => $this->request->getVar('PO_qty'),
            'PO_amount' => $this->request->getVar('PO_amount')
        ]);

        $purchase_order_id = $this->purchaseOrderModel->select('tblpurchaseorder.id')
            ->where('tblpurchaseorder.PO_No', $this->request->getVar('PO_No'))
            ->first()->id;

        $size_id = $this->request->getVar('size_id');
        $qty = $this->request->getVar('qty');

        for ($i = 0; $i < count($size_id); $i++) {
            $this->purchaseOrderSizeModel->save([
                'purchase_order_id' => $purchase_order_id,
                'size_id' => $size_id[$i],
                'quantity' => $qty[$i]
            ]);
        }

        $style_no = $this->request->getVar('style_no');
        
        for ($i = 0; $i < count($style_no); $i++) {
            $this->purchaseOrderStyleModel->save([
                'purchase_order_id' => $purchase_order_id,
                'style_id' => $style_no[$i]
            ]);
        }

        for ($i = 0; $i < count($size_id); $i++) {
            $this->purchaseOrderDetailModel->save([
                'order_id' => $purchase_order_id,
                'style_id' => $style_no[$i],
                'size_id' => $size_id[$i],
                'product_id' => 1,
                'qty' => $qty[$i],
                'price' => 2900
            ]);
        }

        session()->setFlashdata('message', 'Added Successfully!');
        return redirect()->to('/purchaseorder');
    }

    public function delete($PO_No)
    {
        $this->purchaseOrderModel->delete($PO_No);
        session()->setFlashdata('message', 'Deleted Successfully');
        return redirect()->to('/purchaseorder');
    }
}
