<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;
use App\Models\PalletModel;

use \Hermawan\DataTables\DataTable;

class PalletTransfer extends BaseController
{
    protected $PalletTransferModel;
    protected $TransferNoteModel;
    protected $PalletModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->PalletModel = new PalletModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pallet Transfer List',
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
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="edit_pallet('. $row->id .')">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_pallet('. $row->id .')">Delete</a>
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

            })->toJson(true);
    }

    public function create()
    {
        $data = [
            'title' => 'New Pallet Transfer',
        ];
        return view('pallettransfer/create', $data);
        
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
        $transfer_notes = [];
        
        if($get_pallet_transfer->flag_empty == 'Y'){
            $pallet_data['status'] = 'Empty';
        } else {
            $pallet_data['status'] = $this->getPalletStatus($get_pallet_transfer);
            $transfer_notes = $this->PalletTransferModel->getTransferNotesInPallet($get_pallet_transfer->pallet_id);
        }

        $data_return = [
            'status' => 'success',
            'message' => 'Pallet Found',
            'data' => [
                'pallet_info' => $pallet_data,
                'transfer_notes' => $transfer_notes,
            ],
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
