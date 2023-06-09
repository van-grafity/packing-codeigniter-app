<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;
use App\Models\PackinglistCartonModel;

use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CartonBarcode extends BaseController
{
    protected $CartonBarcodeModel;
    protected $PackingListModel;
    protected $PackinglistCartonModel;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
        $this->PackinglistCartonModel = new PackinglistCartonModel();
    }

    public function index()
    {
        $packinglist = $this->PackingListModel->getPackingList();
        array_walk($packinglist, function (&$item, $key) {

            /* 
                if($item->flag_generate_carton == 'Y') {
                    $item->btn_generate_class = 'd-none';
                    $item->btn_detail_class = 'd-inline-block';
                } else {
                    $item->btn_generate_class = 'd-inline-block';
                    $item->btn_detail_class = 'd-none';
                }
            */

            if($item->flag_generate_carton == 'Y') {
                $item->btn_generate_class = '';
                $item->btn_detail_class = '';
            } else {
                $item->btn_generate_class = '';
                $item->btn_detail_class = '';
            }
        });
        
        $data = [
            'title' => 'Carton Barcode Setup',
            'packinglist' => $packinglist,
        ];
        return view('carton-barcode/index', $data);
    }

    public function detail($id)
    {
        $packinglist = $this->PackingListModel->getPackingList($id);
        $packinglist->total_carton = $this->PackingListModel->getTotalCarton($id);
        $packinglist->percentage_ship = $this->PackingListModel->get_percentage_ship($id);

        $carton_list = $this->CartonBarcodeModel->getCartonByPackinglist($id);
        array_walk($carton_list, function (&$item, $key) {
            if($item->flag_packed == 'Y') {
                $item->packed_status = '<span class="badge bg-success">Packed</span>';
            } else {
                $item->packed_status = '<span class="badge bg-secondary">Not Packed Yet</span>';
            }
        });
        
        $data = [
            'title' => 'Carton Barcode Setup Detail',
            'packinglist' => $packinglist,
            'carton_list' => $carton_list,
        ];
        
        return view('carton-barcode/detail', $data);
    }

    public function import_excel()
    {
        try {
            $packinglist_id = $this->request->getPost('packinglist_id');
            
            $file = $this->request->getFile('file_excel');
            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            
            $excel_to_array = $this->parse_excel_to_array($worksheet);
            $data_to_update = $excel_to_array['data'];
            array_walk($data_to_update, function (&$item, $key) use ($packinglist_id){
                $item['packinglist_id'] = $packinglist_id;
            });
    
            $this->CartonBarcodeModel->transException(true)->transStart();
            
            $update_barcode = $this->CartonBarcodeModel->update_barcode($data_to_update);
            
            $this->CartonBarcodeModel->transComplete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->to('cartonbarcode/'.$packinglist_id);
    }

    public function generatecarton()
    {
        try {
            $packinglist_id = $this->request->getPost('packinglist_id');
            
            $packinglist_carton = $this->PackinglistCartonModel->getUngeneratedCartonByPackinglistID($packinglist_id);
            $array_of_carton = $this->generate_array_of_carton($packinglist_carton, $packinglist_id);
            
            $this->CartonBarcodeModel->transException(true)->transStart();
            if(!empty($array_of_carton)){
                $this->CartonBarcodeModel->insertBatch($array_of_carton);
            }
            
            // ## update flag on packinglist and packinglist carton
            $data_update = [
                'flag_generate_carton' => 'Y',
                'updated_at'    => now(),
            ];
            $this->PackinglistCartonModel->where('packinglist_id', $packinglist_id)->set($data_update)->update();
            $this->PackingListModel->update($packinglist_id,$data_update);

            $this->CartonBarcodeModel->transComplete();
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return redirect()->to('cartonbarcode/'.$packinglist_id);
    }

    public function detailcarton(){
        
        $carton_id = $this->request->getGet('id');
        $detail_carton = $this->CartonBarcodeModel->getDetailCarton($carton_id);
        
        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton',
            'data' => $detail_carton,
        ];
        return $this->response->setJSON($data_return);
    }

    private function generate_array_of_carton($data_packinglist_carton, $packinglist_id = null)
    {
        if ($packinglist_id) {
            $last_number = $this->CartonBarcodeModel->getLastNumber($packinglist_id);
            $carton_number_by_system = $last_number + 1;
        } else {
            $carton_number_by_system = 1;
        }
        
        $result = [];
        foreach ($data_packinglist_carton as $key => $packinglist_carton) {
            $carton_qty = $packinglist_carton->carton_qty;
            for ($i=0; $i < $carton_qty; $i++) { 
                $carton_barcode = [
                    'packinglist_id' => $packinglist_carton->packinglist_id,
                    'packinglist_carton_id' => $packinglist_carton->id,
                    'carton_number_by_system' => $carton_number_by_system,
                ];
                $result[] = $carton_barcode;
                $carton_number_by_system++;
            }
        }
        return $result;
    }

    private function parse_excel_to_array($worksheet)
    {
        $data = [];
        $firstRow = true;
        $header = [];

        foreach ($worksheet->getRowIterator() as $row) {
            if ($firstRow) {
                foreach ($row->getCellIterator() as $cell) {
                    $header[$cell->getColumn()] = $cell->getValue();
                }
                $firstRow = false;
            } else {
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $columnIndex = $cell->getColumn();
                    $headerIndex = array_key_exists($columnIndex, $header);
                    if ($headerIndex !== false) {
                        $rowData[$header[$columnIndex]] = $cell->getValue();
                        
                    }
                }
                if(!empty($rowData)) {
                    $data[] = $rowData;
                }
            }
        }

        $data_return = [
            'header' => $header,
            'data' => $data,
        ];

        return $data_return;
    }
}
