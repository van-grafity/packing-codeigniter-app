<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CartonInspectionModel;
use App\Models\CartonInspectionDetailModel;
use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

use CodeIgniter\I18n\Time;


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
        $inspection_list = $this->CartonInspectionModel->getCartonInspection();
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
                'issued_date' => $this->request->getPost('issued_date'),
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

    public function detail()
    {
        $inspection_id = $this->request->getGet('id');
        $carton_inspection = $this->CartonInspectionModel->getCartonInspection($inspection_id);
        $carton_inspection_detail = $this->CartonInspectionModel->getCartonInspectionDetail($inspection_id);
        
        $data_return = [
            'status' => 'success',
            'data' => [
                'carton_inspection' => $carton_inspection,
                'carton_inspection_detail' => $carton_inspection_detail,
            ],
            'message' => 'Success retrieving inspection details',
        ];
        return $this->response->setJSON($data_return);
    }

    public function transfernote($inspection_id)
    {
        // dd($inspection_id);
        // dd($this->request->getGet());

        $date_printed = new Time('now');
        $date_printed = $date_printed->toLocalizedString('eeee, dd-MMMM-yyyy HH:mm');

        $filename = 'Inspection Transfer Note - () - PO#' . '1804QWE';

        $data = [
            'title'         => $filename,
            'date_printed'  => $date_printed,
        ];

        return view('cartoninspection/transfernote_pdf', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('cartoninspection/transfernote_pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => false]);
        
    }

}
