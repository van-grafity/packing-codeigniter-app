<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

class Scanpack extends BaseController
{
    protected $CartonBarcodeModel;
    protected $PackingListModel;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Scan Carton',
        ];
        return view('scanpack/index', $data);
    }

    public function detailcarton()
    {
        $carton_barcode = $this->request->getGet('carton_barcode');
        $carton_detail = $this->CartonBarcodeModel->getDetailCartonByBarcode($carton_barcode);
        if(!$carton_detail) {
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found',
            ];
            return $this->response->setJSON($data_return);
        }
        
        $packinglist = $this->CartonBarcodeModel->getCartonInfoByBarcode($carton_barcode);
        $packinglist->total_carton = $this->PackingListModel->getTotalCarton($packinglist->packinglist_id);
        $packinglist->total_pcs = array_sum(array_map(fn( $product ) => $product->product_qty, $carton_detail)); 
        
        $data = [
            'data_po' => $packinglist,
            'carton_detail' => $carton_detail,
        ];
        
        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton',
            'data' => $data,
        ];
        return $this->response->setJSON($data_return);

    }

    public function packcarton()
    {
        $carton_id = $this->request->getVar('carton_id');
        $data = [
            'flag_packed' => 'Y',
        ];
        $this->CartonBarcodeModel->update($carton_id, $data);
        return redirect()->to('scanpack');
    }
}
