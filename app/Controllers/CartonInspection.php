<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CartonInspectionModel;
use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

class CartonInspection extends BaseController
{
    protected $CartonInspectionModel;
    protected $CartonBarcodeModel;
    protected $PackingListModel;
    protected $session;

    public function __construct()
    {
        $this->CartonInspectionModel = new CartonInspectionModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Carton Inspection',
            'carton_inspection' => $this->CartonInspectionModel->findAll(),
        ];
        
        return view('cartoninspection/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Create New Inspection',
        ];
        return view('cartoninspection/create', $data);
    }

    public function detailcarton()
    {
        $carton_barcode = $this->request->getGet('carton_barcode');
        $carton_detail = $this->CartonBarcodeModel->getDetailCartonByBarcode($carton_barcode);
        if (!$carton_detail) {
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found',
            ];
            return $this->response->setJSON($data_return);
        }

        $carton = $this->CartonBarcodeModel->getCartonInfoByBarcode_v2($carton_barcode);
        
        $carton->total_carton = $this->PackingListModel->getTotalCarton($carton->packinglist_id);
        $carton->total_pcs = array_sum(array_map(fn ($product) => $product->product_qty, $carton_detail));

        $data = [
            'carton_info' => $carton,
            'carton_detail' => $carton_detail,
        ];

        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton',
            'data' => $data,
        ];
        return $this->response->setJSON($data_return);
    }

}
