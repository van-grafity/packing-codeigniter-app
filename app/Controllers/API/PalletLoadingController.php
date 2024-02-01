<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PalletModel;
use App\Models\RackModel;
use App\Models\TransferNoteModel;
use App\Models\PalletTransferModel;
use App\Models\CartonBarcodeModel;

use App\Controllers\API\PalletTransferController;

use CodeIgniter\I18n\Time;

class PalletLoadingController extends ResourceController
{
    use ResponseTrait;

    protected $PalletModel;
    protected $RackModel;
    protected $TransferNoteModel;
    protected $PalletTransferModel;
    protected $CartonBarcodeModel;
    protected $PalletTransferController;

    public function __construct()
    {
        $this->PalletModel = new PalletModel();
        $this->RackModel = new RackModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PalletTransferController = new PalletTransferController();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function search_pallet()
    {
        $data_input = $this->request->getGet();
        
        // ## parameters validation
        $params_to_check = ['pallet_barcode'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_return);
        }


        $pallet = $this->PalletModel->where('serial_number', $data_input['pallet_barcode'])->first();
        if(!$pallet){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->respond($data_return);
        }

        $pallet_transfer = $this->RackModel->searchPalletTransferInRack($pallet->id);
        if(!$pallet_transfer || !$pallet_transfer->pallet_transfer_id){
            $data_return = [
                'status' => 'error',
                'message' => 'The pallet was not found in the rack',
            ];
            return $this->respond($data_return);
        }

        $pallet_status = $this->PalletTransferController->getPalletStatus($pallet_transfer);
        $pallet_transfer->status = $pallet_status['status'];
        $pallet_transfer->color_hex = $pallet_status['color_hex'];

        // !! kalau pakai yang versi 2 $pallet_transfer_detail tidak di perlukan lagi. silahkan hapus semua yang berhubungan dengan ini
        $pallet_transfer_detail = $this->PalletTransferModel->getCartonInPalletTransfer($pallet_transfer->pallet_transfer_id);

        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer->pallet_transfer_id);
        foreach ($transfer_note_list as $key => $transfer_note) {
            // ## only need carton that not loaded
            $where_options = [
                'flag_loaded' => 'N'
            ];
            $transfer_note->cartons = $this->TransferNoteModel->getCartonInTransferNote($transfer_note->id, $where_options);
        }

        // $pallet_transfer->pallet_transfer_detail = $pallet_transfer_detail;
        $pallet_transfer->pallet_serial_number = $pallet_transfer->pallet_number;
        $pallet_transfer->transfer_notes = $transfer_note_list;

        $data_return = [
            'status' => 'success',
            'message' => 'Successfully get pallet information',
            'data' => [
                'pallet_transfer' => $pallet_transfer,
            ],
        ];

        return $this->respond($data_return);
    }

    public function create()
    {
        $data_input = $this->request->getPost();
        
        // ## parameters validation
        $params_to_check = ['transfer_note_id'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_return);
        }

        $transfer_note_id_list = $data_input['transfer_note_id'];

        $where_options = [
            'flag_loaded' => 'N'
        ];
        $carton_counter = 0;
        foreach ($transfer_note_id_list as $key => $transfer_note_id) {
            $carton_list = $this->TransferNoteModel->getCartonInTransferNote($transfer_note_id,$where_options);
            if(!$carton_list) { continue; }
            foreach ($carton_list as $key_carton => $carton) {
                $date_update = [
                    'flag_loaded' => 'Y',
                    'loaded_at' => date('Y-m-d H:i:s'),
                ];
                $this->CartonBarcodeModel->update($carton->carton_id, $date_update);
                $carton_counter++;
            }
            
        }

        if($carton_counter <= 0) {
            $data_return = [
                'status' => 'error',
                'message' => 'No Carton Loaded',
            ];
            return $this->respond($data_return);
        } else {
            $data_return = [
                'status' => 'success',
                'message' => 'Successfully Load '. $carton_counter .' Carton',
            ];
            return $this->respond($data_return);
        }

    }
}
