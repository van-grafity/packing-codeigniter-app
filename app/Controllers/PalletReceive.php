<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletReceiveModel;
use App\Models\TransferNoteModel;
use App\Models\RackModel;
use App\Models\RackPalletModel;
use App\Models\PalletTransferModel;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class PalletReceive extends BaseController
{
    protected $PalletReceiveModel;
    protected $TransferNoteModel;
    protected $RackModel;
    protected $RackPalletModel;
    protected $PalletTransferModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletReceiveModel = new PalletReceiveModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->RackModel = new RackModel();
        $this->RackPalletModel = new RackPalletModel();
        $this->PalletTransferModel = new PalletTransferModel();
    }

    public function index()
    {
        $racks = $this->RackModel->findAll();

        $data = [
            'title' => 'Pallet to Receive List',
            'racks' => $racks,
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
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-1" onclick="receive_pallet('. $row->id .')">Receive</a>
                ';
                return $action_button;
            })->add('transfer_note', function($row){
                $transfer_note_result = '';
                $transfer_note_list = $this->TransferNoteModel->where('pallet_transfer_id', $row->id)->findAll();
                
                foreach ($transfer_note_list as $key => $transfer_note) {
                    $transfer_note_pill ='<a class="btn btn-sm bg-info mb-2">'. $transfer_note->serial_number .'</a>'; 
                    $transfer_note_result = $transfer_note_result . ' ' . $transfer_note_pill;
                }
                
                return $transfer_note_result;
            })->add('status', function($row){
                
                $status = $this->getPalletStatus($row, true);
                return $status;

            })->add('rack', function($row){
                
                $rack = $this->PalletReceiveModel->getPalletLocation($row->id);
                $rack = $rack ? $rack->serial_number : '-';
                return $rack;

            })->postQuery(function ($pallet_list) {
                $pallet_list->orderBy('tblpallettransfer.created_at');
            })->toJson(true);
    }

    public function store()
    {
        $data_input = $this->request->getPost();
        $data = array(
            'rack_id' => $data_input['rack'],
            'pallet_transfer_id' => $data_input['pallet_transfer_id'],
            'entry_date' => date('Y-m-d H:i:s'),
        );
        $this->RackPalletModel->save($data);
        $this->PalletTransferModel->update($data_input['pallet_transfer_id'],['flag_transferred' => 'Y']);
        
        return redirect()->to('pallet-receive')->with('success', "Successfully added Pallet to Rack");
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
