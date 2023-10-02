<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletReceiveModel;
use App\Models\TransferNoteModel;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class PalletReceive extends BaseController
{
    protected $PalletReceiveModel;
    protected $TransferNoteModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletReceiveModel = new PalletReceiveModel();
        $this->TransferNoteModel = new TransferNoteModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pallet to Receive List',
        ];
        return view('palletreceive/index', $data);
    }

    public function index_dt() 
    {
        $pallet_list = $this->PalletReceiveModel->getDatatable();
        return DataTable::of($pallet_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a href="javascript:void(0);" class="btn btn-info btn-sm mb-1" onclick="receive_pallet('. $row->id .')">Receive</a>
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
