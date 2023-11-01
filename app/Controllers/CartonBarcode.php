<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;
use App\Models\PackinglistCartonModel;
use App\Models\StyleModel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use \Hermawan\DataTables\DataTable;


class CartonBarcode extends BaseController
{
    protected $CartonBarcodeModel;
    protected $PackingListModel;
    protected $PackinglistCartonModel;
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
        $this->PackinglistCartonModel = new PackinglistCartonModel();
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
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

            if ($item->flag_generate_carton == 'Y') {
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

        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        // return view('cartonbarcode/index', $data);
        return view('cartonbarcode/index_dt', $data);
    }

    public function index_dt()
    {
        $po_list = $this->PackingListModel->getDatatable();
        return DataTable::of($po_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a class="btn btn-primary btn-sm mb-1 mr-2"
                        data-id="' . $row->packinglist_id .'"
                        data-packinglist-number="'. $row->packinglist_serial_number .'"
                        onclick="generate_carton(this)"
                    >Generate Carton</a>
                    <a href="'.base_url('cartonbarcode/'.$row->packinglist_id).'" class="btn btn-info btn-sm mb-1 mr-2">Detail</a>
                ';
                return $action_button;
            })->edit('packinglist_serial_number', function($row){
                $pl_number_link = '<a href="'. base_url('packinglist/').$row->packinglist_id.'">'.$row->packinglist_serial_number .'</a>';
                return $pl_number_link;

            })->edit('po_no', function($row){
                $po_number_link = '<a href="'. base_url('purchaseorder/').$row->po_id.'">'.$row->po_no .'</a>';
                return $po_number_link;

            })->postQuery(function ($pl_list) {
                $pl_list->orderBy('pl.created_at','desc');
            })->toJson(true);
    }

    public function detail($id)
    {

        if (in_array(session()->get('role'), ['superadmin'])) {
            $superadmin_only_class = '';
        } else {
            $superadmin_only_class = 'd-none';
        }

        $packinglist = $this->PackingListModel->getPackingList($id);
        $packinglist->total_carton = $this->PackingListModel->getTotalCarton($id);
        $packinglist->percentage_ship = $this->PackingListModel->getShipmentPercentage($id);

        $style_by_gl = $this->StyleModel->getStyleByPO($packinglist->packinglist_po_id);
        $packinglist->style_no = implode(' | ', (array_column($style_by_gl, 'style_no')));
        $packinglist->style_description = implode(' | ', (array_column($style_by_gl, 'style_description')));

        $carton_list = $this->CartonBarcodeModel->getCartonByPackinglist($id);
        array_walk($carton_list, function (&$item, $key) {
            if ($item->flag_packed == 'Y') {
                $item->packed_status = '<span class="badge bg-success">Packed</span>';
            } else {
                $item->packed_status = '<span class="badge bg-secondary">Not Packed Yet</span>';
            }
        });

        $data = [
            'title' => 'Carton Barcode Setup Detail',
            'packinglist' => $packinglist,
            'carton_list' => $carton_list,
            'superadmin_only_class' => $superadmin_only_class,
        ];

        return view('cartonbarcode/detail', $data);
    }

    public function importexcel()
    {
        try {
            $packinglist_id = $this->request->getPost('packinglist_id');
            $file = $this->request->getFile('file_excel');
            $rules = [
                'file_excel' => 'ext_in[file_excel,csv,xlsx,xls]',
            ];
            if (!$this->validate($rules)) {
                return redirect()->to('cartonbarcode/' . $packinglist_id)->with('error', 'Please upload on csv / xlsx / xls format');
            }

            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $is_valid = $this->is_valid_header($worksheet);
            if (!$is_valid) {
                return redirect()->to('cartonbarcode/' . $packinglist_id)->with('error', 'Incorrect header format');
            }

            $excel_to_array = $this->parse_excel_to_array($worksheet);
            $data_to_update = $excel_to_array['data'];

            array_walk($data_to_update, function (&$item, $key) use ($packinglist_id) {
                $item['packinglist_id'] = $packinglist_id;
                $item['carton_number_by_system'] = $item['carton_number'];
                unset($item['carton_number']);
            });

            $this->CartonBarcodeModel->transException(true)->transStart();

            $updateCartonBarcode = $this->CartonBarcodeModel->updateCartonBarcode($data_to_update);

            $this->CartonBarcodeModel->transComplete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->to('cartonbarcode/' . $packinglist_id);
    }

    public function generatecarton()
    {
        try {
            $packinglist_id = $this->request->getPost('packinglist_id');

            $packinglist_carton = $this->PackinglistCartonModel->getUngeneratedCartonByPackinglistID($packinglist_id);
            $array_of_carton = $this->generate_array_of_carton($packinglist_carton, $packinglist_id);

            $this->CartonBarcodeModel->transException(true)->transStart();
            if (!empty($array_of_carton)) {
                $this->CartonBarcodeModel->insertBatch($array_of_carton);
            }

            // ## update flag on packinglist and packinglist carton
            $data_update = [
                'flag_generate_carton' => 'Y',
                'updated_at'    => now(),
            ];
            $this->PackinglistCartonModel->where('packinglist_id', $packinglist_id)->set($data_update)->update();
            $this->PackingListModel->update($packinglist_id, $data_update);

            $this->CartonBarcodeModel->transComplete();
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->to('cartonbarcode/' . $packinglist_id);
    }

    public function detailcarton()
    {
        $carton_id = $this->request->getGet('id');
        $detail_carton = $this->CartonBarcodeModel->getDetailCarton($carton_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton data',
            'data' => $detail_carton,
        ];
        return $this->response->setJSON($data_return);
    }

    public function unpack_carton()
    {
        $packinglist_id = $this->request->getGet('packinglist_id');
        $carton_barcode_id = $this->request->getGet('carton_barcode_id');
        
        $unpacked_carton = $this->CartonBarcodeModel->unpackCarton($packinglist_id, $carton_barcode_id);
        
        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully unpack '. count($unpacked_carton).' carton',
            'data' => $unpacked_carton,
        ];
        return $this->response->setJSON($data_return);
    }

    public function clear_barcode()
    {
        $packinglist_id = $this->request->getGet('packinglist_id');
        $carton_barcode_id = $this->request->getGet('carton_barcode_id');

        // ## ketika barcode di hapus, maka status harus unpack juga
        $unpacked_carton = $this->CartonBarcodeModel->unpackCarton($packinglist_id, $carton_barcode_id);
        $cleared_carton = $this->CartonBarcodeModel->clearBarcode($packinglist_id, $carton_barcode_id);
        
        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully clear '. count($cleared_carton).' carton barcode',
            'data' => $cleared_carton,
        ];
        return $this->response->setJSON($data_return);
    }

    public function delete_carton()
    {
        $packinglist_id = $this->request->getGet('packinglist_id');
        $carton_barcode_id = $this->request->getGet('carton_barcode_id');

        $deleted_carton = $this->CartonBarcodeModel->deleteCarton($packinglist_id, $carton_barcode_id);
        //## ketika delete carton, packinglist cartonnya juga di balikin ke flag_generate_carton = N sehingga terdeteksi sebagai belum generate. karena kalau sudah generate packinglist carton, maka tidak bisa generate ulang. untuk menghindari double generate
        
        $this->PackinglistCartonModel->where('packinglist_id', $packinglist_id)->set('flag_generate_carton', 'N')->update();
        
        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully delete '. count($deleted_carton).' carton',
            'data' => $deleted_carton,
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
            for ($i = 0; $i < $carton_qty; $i++) {
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
                if (!empty($rowData)) {
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

    private function is_valid_header($worksheet)
    {
        // ## get first row in worksheet and check valid name
        $header_from_excel = $worksheet->toArray()[0];;
        $header_list = ['carton_number', 'barcode'];
        foreach ($header_list as $key => $header) {
            if ($header != $header_from_excel[$key]) return false;
        }
        return true;
    }
}
