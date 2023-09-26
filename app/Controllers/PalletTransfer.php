<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;
use App\Models\PalletModel;
use App\Models\CartonBarcodeModel;
use App\Models\LocationModel;

use \Hermawan\DataTables\DataTable;

class PalletTransfer extends BaseController
{
    protected $PalletTransferModel;
    protected $TransferNoteModel;
    protected $PalletModel;
    protected $CartonBarcodeModel;
    protected $LocationModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->PalletModel = new PalletModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->LocationModel = new LocationModel();
    }

    public function index()
    {

        $location = $this->LocationModel->findAll();
        $data = [
            'title' => 'Pallet to Transfer List',
            'location' => $location
        ];
        return view('pallettransfer/index', $data);
    }

    public function index_dt() 
    {
        $pallet_list = $this->PalletTransferModel->getDatatable();
        return DataTable::of($pallet_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="edit_pallet_transfer('. $row->id .')">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_pallet_transfer('. $row->id .')">Delete</a>
                ';
                return $action_button;
            })->add('transfer_note', function($row){
                $transfer_note_result = '';
                $transfer_note_list = $this->TransferNoteModel->where('pallet_transfer_id', $row->id)->findAll();
                
                foreach ($transfer_note_list as $key => $transfer_note) {
                    $transfer_note_pill ='<a class="btn btn-sm bg-info">'. $transfer_note->serial_number .'</a>'; 
                    $transfer_note_result = $transfer_note_result . ' ' . $transfer_note_pill;
                }
                
                return $transfer_note_result;
            })->add('status', function($row){
                
                $status = $this->getPalletStatus($row, true);
                return $status;

            })->postQuery(function ($pallet_list) {
                $pallet_list->orderBy('tblpallettransfer.created_at');
            })->toJson(true);
    }

    public function create()
    {
        $data = [
            'title' => 'New Pallet Transfer',
        ];
        return view('pallettransfer/create', $data);
        
    }

    public function store()
    {
        $data_input = $this->request->getPost();
        $pallet = $this->PalletModel->where('serial_number', $data_input['pallet_serial_number'])->first();
        
        
        $data = array(
            'location_from_id' => $data_input['location_from'],
            'location_to_id' => $data_input['location_to'],
            'pallet_id' => $pallet->id,
            'flag_transferred' => 'N',
            'flag_loaded' => 'N',
        );
        
        $this->PalletTransferModel->save($data);
        return redirect()->to('pallet-transfer')->with('success', "Successfully added Pallet to Transfer");
    }

    public function detail()
    {
        $id = $this->request->getGet('id');

        $pallet_transfer = $this->PalletTransferModel->join('tblpallet as pallet','pallet.id = tblpallettransfer.pallet_id')->where('tblpallettransfer.id', $id)->select('tblpallettransfer.*, pallet.serial_number as pallet_serial_number')->first();
        $data_return = [
            'status' => 'success',
            'message' => 'Pallet Transfer Found',
            'data' => $pallet_transfer,
        ];
        return $this->response->setJSON($data_return);
    }

    public function update()
    {
        $data_input = $this->request->getPost();
        
        $data = array(
            'location_from_id' => $data_input['location_from'],
            'location_to_id' => $data_input['location_to'],
        );
        $this->PalletTransferModel->update($data_input['edit_pallet_transfer_id'],$data);
        return redirect()->to('pallet-transfer')->with('success', "Successfully updated Pallet to Transfer");
    }

    public function pallet_detail()
    {
        $pallet_serial_number = $this->request->getGet('pallet_serial_number');
        
        $pallet = $this->PalletModel->where('serial_number', $pallet_serial_number)->first();
        if(!$pallet){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->response->setJSON($data_return);
        }
        
        $get_pallet_transfer = $this->PalletTransferModel->getDetailPalletBySerialNumber($pallet_serial_number);
        
        $pallet_data = [
            'pallet_number' => $get_pallet_transfer->pallet_number,
            'location_from' => $get_pallet_transfer->location_from ? $get_pallet_transfer->location_from : '-',
            'location_to' => $get_pallet_transfer->location_to ? $get_pallet_transfer->location_to : '-',
        ];
        $transfer_note_list = [];
        
        if($get_pallet_transfer->flag_empty == 'Y'){
            $pallet_data['status'] = 'Empty';
        } else {
            $pallet_data['status'] = $this->getPalletStatus($get_pallet_transfer);
            $transfer_note_list = $this->PalletTransferModel->getTransferNotesInPallet($get_pallet_transfer->pallet_id);
        }

        $data_return = [
            'status' => 'success',
            'message' => 'Pallet Found',
            'data' => [
                'pallet_info' => $pallet_data,
                'transfer_note_list' => $transfer_note_list,
            ],
        ];
        return $this->response->setJSON($data_return);

    }

    public function transfer_note_detail()
    {
        $transfer_note_id = $this->request->getGet('transfer_note_id');
        
        $transfer_note = $this->TransferNoteModel->find($transfer_note_id);
        
        if(!$transfer_note){
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found',
            ];
            return $this->response->setJSON($data_return);
        }
        
        $data_return = [
            'status' => 'success',
            'message' => 'Carton Found',
            'data' => $transfer_note,
        ];
        return $this->response->setJSON($data_return);
    }

    public function carton_detail()
    {
        $carton_barcode = $this->request->getGet('carton_barcode');
        
        $carton_info = $this->CartonBarcodeModel->getCartonInfoByBarcode_v2($carton_barcode);
        if(!$carton_info){
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found',
            ];
            return $this->response->setJSON($data_return);
        }

        $size_list_in_carton = $this->CartonBarcodeModel->getCartonContent($carton_info->carton_id);
        $carton_info->content = $this->CartonBarcodeModel->serialize_size_list($size_list_in_carton);
        $carton_info->total_pcs = array_sum(array_column($size_list_in_carton,'qty'));
        
        $data_return = [
            'status' => 'success',
            'message' => 'Carton Found',
            'data' => $carton_info,
        ];
        return $this->response->setJSON($data_return);
    }

    public function check_pallet_availablity()
    {
        $pallet_serial_number = $this->request->getGet('pallet_serial_number');
        $pallet = $this->PalletModel->where('serial_number', $pallet_serial_number)->first();

        if(!$pallet){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->response->setJSON($data_return);
        }

        if($pallet->flag_empty == 'N') {
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet Found',
                'data' => [
                    'pallet_status' => false,
                    'feedback_title' => 'Pallet is not Available',
                    'feedback_message' => 'This Pallet has not empty',
                ]
            ];
            return $this->response->setJSON($data_return);
        }

        $get_last_pallet_transfer = $this->PalletTransferModel->getLastPalletTransferByPalletID($pallet->id);

        if($pallet->flag_empty == 'Y' && $get_last_pallet_transfer == null){
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet Found',
                'data' => [
                    'pallet_status' => true,
                    'feedback_title' => 'Pallet is Available',
                ]
            ];
            return $this->response->setJSON($data_return);
        }

        if($get_last_pallet_transfer->flag_transferred == 'Y' && $get_last_pallet_transfer->flag_loaded == 'Y'){
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet Found',
                'data' => [
                    'pallet_status' => true,
                    'feedback_title' => 'Pallet is Available',
                ]
            ];
            return $this->response->setJSON($data_return);
        }
        
        $data_return = [
            'status' => 'success',
            'message' => 'Pallet Found',
            'data' => [
                'pallet_status' => false,
                'feedback_title' => 'Pallet is not Available!',
                'feedback_message' => 'This Pallet has been used. Please Check at Pallet to Transfer List',
            ]
        ];
        return $this->response->setJSON($data_return);

    }

    private function getPalletStatus($pallet_data, $pill_mode = false)
    {
        if($pill_mode){
            if($pallet_data->flag_transferred == 'N' && $pallet_data->flag_loaded == 'N'){
                $status = '<span class="badge badge-secondary">Not Transfered Yet</span>';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
                $status = '<span class="badge badge-info">at Warehouse</span>';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
                $status = '<span class="badge badge-success">Loaded</span>';
            } else {
                $status = '<span class="badge badge-danger">Unknown Status</span>';
            }
        } else {
            if($pallet_data->flag_transferred == 'N' && $pallet_data->flag_loaded == 'N'){
                $status = 'Not Transferred Yet';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
                $status = 'at Warehouse';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
                $status = 'Loaded';
            } else {
                $status = 'Unknown Status';
            }
        }

        return $status;
    }
}
