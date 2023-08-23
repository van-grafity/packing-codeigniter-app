<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CartonInspectionModel;
use App\Models\CartonInspectionDetailModel;
use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

class CartonInspection extends BaseController
{
    protected $CartonInspectionModel;
    protected $CartonInspectionDetailModel;
    protected $CartonBarcodeModel;
    protected $PackingListModel;
    protected $session;

    public function __construct()
    {
        $this->CartonInspectionModel = new CartonInspectionModel();
        $this->CartonInspectionDetailModel = new CartonInspectionDetailModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
    }

    public function index()
    {
        $inspection_list = $this->CartonInspectionModel->findAll();
        foreach ($inspection_list as $key => $inspection) {
            $inspection_list[$key]['carton_number'] = '100';
        } 
        $data = [
            'title' => 'Carton Inspection',
            'carton_inspection' => $inspection_list,
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

    public function store()
    {

        $carton_ids = $this->request->getPost('carton_ids');
        try {
            $carton_inspection = [
                'issued_by' => $this->request->getPost('issued_by'),
                'received_by' => $this->request->getPost('received_by'),
                'received_date' => $this->request->getPost('received_date'),
            ];
            $this->CartonInspectionModel->transException(true)->transStart();
            $carton_inspection_id = $this->CartonInspectionModel->insert($carton_inspection);
            
            foreach ($carton_ids as $key => $carton_id) {
                $carton_inspection_detail = [
                    'carton_inspection_id' => $carton_inspection_id,
                    'carton_barcode_id' => $carton_id,
                ];
                $carton_inspection_detail_id[] = $this->CartonInspectionDetailModel->insert($carton_inspection_detail);
            }
            
            $this->CartonInspectionModel->transComplete();
            $cartons_issued = count($carton_inspection_detail_id);
            return redirect()->to('cartoninspection');

            // throw new \Exception('Buat Error manual, nanti masuk ke catch');

        } catch (\Throwable $th) {
            // dd($th);
            
            throw $th;

        }
        
    }

}
