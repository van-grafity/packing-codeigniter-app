<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

use PhpOffice\PhpSpreadsheet\IOFactory;

// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CartonBarcode extends BaseController
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
            'title' => 'Carton Barcode Setup',
            // 'packinglist' => $this->PackingListModel->getPackingList(),
        ];

        // return view('carton/index', $data);
        return view('carton-barcode/index', $data);
    }

    public function import_excel()
    {
        $file = $this->request->getFile('file_excel');
        $spreadsheet = IOFactory::load($file->getTempName());
        $worksheet = $spreadsheet->getActiveSheet();
        
        $excel_to_array = $this->parsing_excel_to_array($worksheet);
        $excel_to_array = $excel_to_array['data'];
        $data_to_update = array_walk($excel_to_array, function (&$item, $key) {
            $item['packinglist_carton_id'] = '2';
        });

        // $update_barcode = $this->CartonBarcodeModel->insertBatch($excel_to_array);
        // $update_barcode = $this->CartonBarcodeModel->updateBatch($excel_to_array);
        $update_barcode = $this->CartonBarcodeModel->update_barcode($excel_to_array);
        // $update_barcode = $this->CartonBarcodeModel->update_barcode_v2($excel_to_array);

        // dd($update_barcode);
        
        return redirect()->to('cartonbarcode');
    }

    private function parsing_excel_to_array($worksheet)
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
