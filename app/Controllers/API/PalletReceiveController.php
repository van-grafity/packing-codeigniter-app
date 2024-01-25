<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PalletTransferModel;
use App\Models\PalletReceiveModel;
use App\Models\CartonBarcodeModel;
use App\Models\TransferNoteModel;
use App\Models\TransferNoteDetailModel;
use App\Models\PalletModel;
use App\Models\RackModel;
use App\Models\RackPalletModel;

use App\Controllers\API\PalletTransferController;

use CodeIgniter\I18n\Time;

class PalletReceiveController extends ResourceController
{
    use ResponseTrait;

    protected $PalletTransferModel;
    protected $PalletReceiveModel;
    protected $CartonBarcodeModel;
    protected $TransferNoteModel;
    protected $TransferNoteDetailModel;
    protected $PalletModel;
    protected $RackModel;
    protected $RackPalletModel;
    protected $PalletTransferController;

    public function __construct()
    {
        $this->PalletTransferModel = new PalletTransferModel();
        $this->PalletReceiveModel = new PalletReceiveModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->TransferNoteDetailModel = new TransferNoteDetailModel();
        $this->PalletModel = new PalletModel();
        $this->RackModel = new RackModel();
        $this->RackPalletModel = new RackPalletModel();
        $this->PalletTransferController = new PalletTransferController();
        
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $params = [
            'length' => $this->request->getGet('limit') ? $this->request->getGet('limit') : 10,
            'page' => $this->request->getGet('page') ? $this->request->getGet('page') : 1,
        ];
        $pallet_receive_dt = $this->PalletReceiveModel->getDatatable();
        $pallet_receive_list = $pallet_receive_dt->orderBy('tblpallettransfer.created_at', 'DESC')->paginate($params['length'],'default',$params['page']);

        foreach ($pallet_receive_list as $key => $pallet_receive) {
            $pallet_status = $this->PalletTransferController->getPalletStatus($pallet_receive);
            $pallet_receive_list[$key]->status = $pallet_status['status'];
            $pallet_receive_list[$key]->color_hex = $pallet_status['color_hex'];
        }
        $data_response = [
            'status' => 'success',
            'message' => 'Berhasil Mendapatkan Data Pallet Receive',
            'data' => [
                'pallet_receive_list' => $pallet_receive_list
            ]
        ];
        
        return $this->respond($data_response);
    }

    public function search_pallet()
    {
        $data_input = $this->request->getGet();

        // ## parameters validation
        $params_to_check = ['pallet_barcode'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response, 404);
        }

        $pallet_transfer = $this->PalletReceiveModel->getPalletTransferByPalletNumber($data_input['pallet_barcode']);
        if(!$pallet_transfer){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->respond($data_return, 404);
        }

        if($pallet_transfer->flag_transferred == 'Y'){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet are Already in the warehouse',
            ];
            return $this->respond($data_return, 400);
        }


        $pallet_status = $this->PalletTransferController->getPalletStatus($pallet_transfer);
        $pallet_transfer->status = $pallet_status['status'];
        $pallet_transfer->color_hex = $pallet_status['color_hex'];

        $transfer_note_list = $this->PalletTransferModel->getTransferNotesByPalletTransfer($pallet_transfer->pallet_transfer_id);

        array_walk($transfer_note_list, function (&$item, $key) {
            if($item->created_at){
                $created_datetime = new Time($item->created_at);
                $created_datetime = $created_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
                $item->created_at = $created_datetime;
            }
        });
        $pallet_transfer->pallet_serial_number = $pallet_transfer->pallet_number;
        $pallet_transfer->transfer_notes = $transfer_note_list;
        $data_return = [
            'status' => 'success',
            'message' => 'Berhasil mendapat data pallet',
            'data' => [
                'pallet_transfer' => $pallet_transfer
            ],
        ];
        return $this->respond($data_return);
    }

    public function create()
    {
        $data_input = $this->request->getPost();
        
        // ## parameters validation
        $params_to_check = ['pallet_transfer_id','pallet_barcode','rack','received_by'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_return, 404);
        }

        $pallet_transfer = $this->PalletReceiveModel->getPalletTransferByPalletNumber($data_input['pallet_barcode']);
        if(!$pallet_transfer){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->respond($data_return, 404);
        }
        
        if($pallet_transfer->flag_transferred == 'Y'){
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet are Already in the warehouse',
                'data' => [
                ],
            ];
            return $this->respond($data_return);
        }


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

        $pallet_transfer = $this->PalletTransferModel->getPalletTransfer($data_input['pallet_transfer_id']);
        
        $data_return = [
            'status' => 'success',
            'message' => 'Berhasil menerima dan mengirim pallet ke rack',
            'data' => [
                'pallet_transfer' => $pallet_transfer,
                'transfer_note_list' => $transfer_note_list,
            ],
        ];
        return $this->respond($data_return);
    }
}
