<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SyncPurchaseOrderModel;
use App\Models\PurchaseOrderModel;
use App\Models\GlModel;

class SyncPurchaseOrder extends BaseController
{
    protected $SyncPurchaseOrderModel;
    protected $PurchaseOrderModel;
    protected $GlModel;

    public function __construct()
    {
        $this->SyncPurchaseOrderModel = new SyncPurchaseOrderModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->GlModel = new PurchaseOrderModel();
    }

    public function index()
    {
        $po_id = $this->request->getGet('po_id');
        if($po_id){
            $purchase_order_list = $this->PurchaseOrderModel->where('id', $po_id)->findAll();
        } else {
            $purchase_order_list = $this->PurchaseOrderModel->findAll();
        }

        if(!$purchase_order_list){
            $result = [
                'status' => 'error',
                'message' => 'PO not found!',
            ];
            return $this->response->setJSON($result);
        }

        foreach ($purchase_order_list as $key => $purchase_order) {
            $buyer_list = $this->SyncPurchaseOrderModel->getBuyerByPurchaseOrder($purchase_order['id']);
            $buyer_list = array_map(function ($buyer) { return $buyer->buyer_name; }, $buyer_list);
            $buyer_name = implode(', ', $buyer_list);
            
            $gl_list = $this->SyncPurchaseOrderModel->getGlByPurchaseOrder($purchase_order['id']);
            
            $gl_number_list = array_map(function ($gl) { return $gl->gl_number; }, $gl_list);
            $gl_number = implode(', ', $gl_number_list);
            $season_list = array_map(function ($gl) { return $gl->season; }, $gl_list);
            $season = implode(', ', $season_list);

            $data_po_insert = [
                'purchase_order_id' => $purchase_order['id'],
                'buyer_name' => $buyer_name,
                'gl_number' => $gl_number,
                'season' => $season,
            ];
            $synchronized_pos[] = $this->SyncPurchaseOrderModel->createOrUpdate($data_po_insert);
        }

        $result = [
            'status' => 'success',
            'message' => 'Success syncronized '.count($synchronized_pos).' Purchase Order',
            'data' => $synchronized_pos, 
        ];
        return $this->response->setJSON($result);
    }

    public function sync_po_gl($po_id)
    {
        if($po_id){
            $purchase_order_list = $this->PurchaseOrderModel->where('id', $po_id)->findAll();
        } else {
            $purchase_order_list = $this->PurchaseOrderModel->findAll();
        }

        if(!$purchase_order_list){
            $result = [
                'status' => 'error',
                'message' => 'PO not found!',
            ];
            return ($result);
        }

        foreach ($purchase_order_list as $key => $purchase_order) {
            $buyer_list = $this->SyncPurchaseOrderModel->getBuyerByPurchaseOrder($purchase_order['id']);
            $buyer_list = array_map(function ($buyer) { return $buyer->buyer_name; }, $buyer_list);
            $buyer_name = implode(', ', $buyer_list);
            
            $gl_list = $this->SyncPurchaseOrderModel->getGlByPurchaseOrder($purchase_order['id']);
            
            $gl_number_list = array_map(function ($gl) { return $gl->gl_number; }, $gl_list);
            $gl_number = implode(', ', $gl_number_list);
            $season_list = array_map(function ($gl) { return $gl->season; }, $gl_list);
            $season = implode(', ', $season_list);

            $data_po_insert = [
                'purchase_order_id' => $purchase_order['id'],
                'buyer_name' => $buyer_name,
                'gl_number' => $gl_number,
                'season' => $season,
            ];
            $synchronized_pos[] = $this->SyncPurchaseOrderModel->createOrUpdate($data_po_insert);
        }

        $result = [
            'status' => 'success',
            'message' => 'Success syncronized '.count($synchronized_pos).' Purchase Order',
            'data' => $synchronized_pos, 
        ];
        return ($result);
    }

    public function sync_po_detail()
    {
        $purchase_order_list = $this->PurchaseOrderModel->findAll();
        
        foreach ($purchase_order_list as $key => $purchase_order) {
            $synchronized_po_details[] = $this->PurchaseOrderModel->syncPurchaseOrderDetails($purchase_order['id']);
        }

        $result = [
            'status' => 'success',
            'message' => 'Success syncronized detail '.count($synchronized_po_details).' Purchase Order',
            'data' => $synchronized_po_details, 
        ];
        return $this->response->setJSON($result);
    }
}
