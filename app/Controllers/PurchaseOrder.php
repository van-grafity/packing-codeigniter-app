<?php

namespace App\Controllers;

use App\Models\BuyerModel;
use App\Models\GLModel;
use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderDetailModel;
use App\Models\ProductModel;
use App\Models\SizeModel;

helper('number');

class PurchaseOrder extends BaseController
{
    protected $BuyerModel;
    protected $GLModel;
    protected $PurchaseOrderModel;
    protected $PurchaseOrderDetailModel;
    protected $ProductModel;
    protected $SizeModel;

    public function __construct()
    {
        $this->BuyerModel = new BuyerModel();
        $this->GLModel = new GLModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->PurchaseOrderDetailModel = new PurchaseOrderDetailModel();
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
        return view('purchaseorder/index', $data);
    }

    public function savePO()
    {
        $data_po = array(
            'PO_No'        => $this->request->getVar('PO_No'),
            'gl_id'        => $this->request->getVar('gl_no'),
            'shipdate'     => $this->request->getVar('shipdate'),
            'PO_qty'       => $this->request->getVar('total_order_qty'),
            'PO_amount'    => $this->request->getVar('total_amount'),
        );

        try {
            $this->PurchaseOrderModel->transException(true)->transStart();

            $po_id = $this->PurchaseOrderModel->savePO($data_po);
            if (!$po_id) {
                $this->PurchaseOrderModel->transRollback();
            }

            // ## insert PO Detail
            $product_codes = $this->request->getPost('product_code');
            foreach ($product_codes as $key => $value) {
                $data_po_detail = [
                    'order_id' => $po_id,
                    'product_id' => $this->request->getPost('product_code')[$key],
                    'size_id' => $this->request->getPost('size')[$key],
                    'qty' => $this->request->getPost('order_qty')[$key],
                ];
                $po_detail = $this->PurchaseOrderDetailModel->insert($data_po_detail);
                if (!$po_detail) {
                    $this->PurchaseOrderModel->transRollback();
                }
            }
            $po_number = $this->PurchaseOrderModel->find($po_id)['PO_No'];
            $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_number);

            $this->PurchaseOrderModel->transComplete();
        } catch (DatabaseException $e) {

            // Automatically rolled back already.
        }

        return redirect()->to('/purchaseorder');
    }

    public function detail($code = null)
    {
        $data = [
            'title'     => 'Purchase Order Detail',
            'purchase_order'   => $this->PurchaseOrderModel->getPO($code)->getRow(),
            'purchase_order_details'   => $this->PurchaseOrderModel->getPODetails($code),
            'products'   => $this->ProductModel->getProduct()->getResult(),
            'sizes'     => $this->SizeModel->getSize()->getResult(),
        ];
        return view('purchaseorder/detail', $data);
    }

    public function delete()
    {
        $id = $this->request->getVar('po_id');
        $delete = $this->PurchaseOrderModel->delete($id);
        return redirect()->to('purchaseorder');
    }

    public function adddetail()
    {
        $data_po_detail = array(
            'order_id'        => $this->request->getVar('order_id'),
            'product_id'        => $this->request->getVar('product'),
            'size_id'        => $this->request->getVar('size'),
            'qty'        => $this->request->getVar('order_qty'),
        );
        $this->PurchaseOrderDetailModel->insert($data_po_detail);

        $po_number = $this->request->getVar('po_number');
        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_number);

        return redirect()->to('purchaseorder/' . $po_number);
    }

    public function updatedetail()
    {
        $id = $this->request->getVar('edit_po_detail_id');
        $data_po_detail = array(
            'order_id'        => $this->request->getVar('order_id'),
            'product_id'        => $this->request->getVar('product'),
            'size_id'        => $this->request->getVar('size'),
            'qty'        => $this->request->getVar('order_qty'),
        );
        $this->PurchaseOrderDetailModel->update($id, $data_po_detail);

        $po_number = $this->request->getVar('po_number');
        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_number);

        return redirect()->to('purchaseorder/' . $po_number);
    }

    public function deletedetail()
    {
        $po_number = $this->request->getPost('po_number');
        $po_detail_id = $this->request->getPost('po_detail_id');
        $delete = $this->PurchaseOrderDetailModel->delete($po_detail_id);

        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_number);
        return redirect()->to('purchaseorder/' . $po_number);
    }
}
