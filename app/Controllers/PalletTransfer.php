<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;

use \Hermawan\DataTables\DataTable;

class PalletTransfer extends BaseController
{
    protected $PalletTransferModel;
    protected $TransferNoteModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->TransferNoteModel = new TransferNoteModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pallet Transfer List',
            'action_field_class' => '',
            'pallet_transfer' => $this->PalletTransferModel->getPalletTransfer()
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
                $pill_element = '';
                if($row->flag_transferred == 'N') {
                    $pill_element = '<span class="badge badge-secondary">Not Transfered Yet</span>';
                } else {
                    $pill_element = '<span class="badge badge-success">Transfered</span>';
                }
                return $pill_element;
            })->toJson(true);
    }
}
