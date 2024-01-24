<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletReceiveModel;
use App\Models\TransferNoteModel;
use App\Models\RackModel;
use App\Models\RackPalletModel;
use App\Models\PalletTransferModel;

use App\Controllers\PalletTransfer;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class PalletReceive extends BaseController
{
    protected $PalletReceiveModel;
    protected $TransferNoteModel;
    protected $RackModel;
    protected $RackPalletModel;
    protected $PalletTransferModel;
    protected $PalletTransferController;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletReceiveModel = new PalletReceiveModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->RackModel = new RackModel();
        $this->RackPalletModel = new RackPalletModel();
        $this->PalletTransferModel = new PalletTransferModel();
        
        $this->PalletTransferController = new PalletTransfer();
    }

    public function index()
    {
        $racks = $this->RackModel->where('flag_empty','Y')->findAll();

        $data = [
            'title' => 'Pallet List to Receive',
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

                if($row->flag_ready_to_transfer == 'N') {
                    $action_button = '
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Preparation still in progress">
                            <a class="btn btn-primary btn-sm mb-1 disabled" style="pointer-events: none;" type="button" disabled>Receive</a>
                        </span>
                    ';
                } else if($row->flag_transferred == 'Y') {
                    $action_button = '
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Already Received">
                            <a class="btn btn-primary btn-sm mb-1 disabled" style="pointer-events: none;" type="button" disabled>Receive</a>
                        </span>
                    ';
                } else {
                    if($row->total_carton <= 0) {
                        $action_button = '
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="The Pallet Still Empty">
                                <a class="btn btn-primary btn-sm mb-1 disabled" style="pointer-events: none;" type="button" disabled>Receive</a>
                            </span>
                        ';
                    } else {
                        $action_button = '
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-1" onclick="receive_pallet('. $row->id .')">Receive</a>
                        ';
                    }
                }
                return $action_button;

            })->add('transfer_note', function($row){
                $transfer_note_result = '';
                $transfer_note_list = $this->TransferNoteModel->where('pallet_transfer_id', $row->id)->findAll();
                
                foreach ($transfer_note_list as $key => $transfer_note) {
                    $transfer_note_pill ='<a href="'. url_to('pallet_transfer_transfer_note_print',$transfer_note->id) .'" class="btn btn-sm bg-info mb-1" target="_blank" data-toggle="tooltip" data-placement="top" title="Click to Print">'. $transfer_note->serial_number .'</a>'; 
                    $transfer_note_result = $transfer_note_result . ' ' . $transfer_note_pill;
                }
                
                return $transfer_note_result;
            })->add('status', function($row){
                
                $status = $this->PalletTransferController->getPalletStatus($row, true);
                return $status;

            })->add('rack', function($row){
                
                $rack = $this->PalletReceiveModel->getPalletLocation($row->id);
                $rack = $rack ? $rack->serial_number : '-';
                return $rack;

            })->postQuery(function ($pallet_list) {
                $pallet_list->orderBy('tblpallettransfer.created_at', 'DESC');
            })->toJson(true);
    }

    public function create(){
        $racks = $this->RackModel->where('flag_empty','Y')->findAll();
        $data = [
            'title' => 'Receive Pallet',
            'racks' => $racks,
        ];
        return view('palletreceive/create', $data);
    }

    public function pallet_transfer_detail()
    {
        $data_input = $this->request->getGet();
        $pallet_transfer = $this->PalletReceiveModel->getPalletTransferByPalletNumber($data_input['pallet_barcode']);
        if(!$pallet_transfer){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->response->setJSON($data_return);
        }
        
        $pallet_transfer->status = $this->PalletTransferController->getPalletStatus($pallet_transfer);
        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer->pallet_transfer_id);
        foreach ($transfer_note_list as $key => $transfer_note) {
            $transfer_note->carton_in_transfer_note = $this->TransferNoteModel->getCartonInTransferNote($transfer_note->id);
        }
 
        $data_return = [
            'status' => 'success',
            'message' => 'Successfully get pallet information',
            'data' => [
                'pallet_transfer' => $pallet_transfer,
                'transfer_note_list' => $transfer_note_list,
            ],
        ];
        return $this->response->setJSON($data_return);
    }

    public function store()
    {
        $data_input = $this->request->getPost();

        // ## Update Tiap Transfernote di Pallet Transfer
        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($data_input['pallet_transfer_id']);
        foreach ($transfer_note_list as $key => $transfer_note) {
            $data_transfer_note = [
                'received_by' => $data_input['received_by'],
                'received_at' => date('Y-m-d H:i:s'),
            ];
            $this->TransferNoteModel->update($transfer_note->id, $data_transfer_note);
        }

        // ## Buat Tambahin data di Rack Pallet
        $data_rack_pallet = array(
            'rack_id' => $data_input['rack'],
            'pallet_transfer_id' => $data_input['pallet_transfer_id'],
            'entry_date' => date('Y-m-d H:i:s'),
        );
        $this->RackPalletModel->save($data_rack_pallet);
        
        // ## Update Pallet Transfer Status
        $this->PalletTransferModel->update($data_input['pallet_transfer_id'],['flag_transferred' => 'Y','transferred_at' => date('Y-m-d H:i:s')]);
        
        // ## Update Rack Status
        $this->RackModel->update($data_input['rack'],['flag_empty' => 'N']);
        
        return redirect()->to('pallet-receive')->with('success', "Successfully added Pallet to Rack");
    }


}
