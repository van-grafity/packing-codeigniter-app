<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PalletTransferModel;
use App\Models\PalletModel;

class PalletTransferController extends ResourceController
{
    use ResponseTrait;

    protected $PalletTransferModel;
    protected $PalletModel;

    public function __construct()
    {
        $this->PalletTransferModel = new PalletTransferModel();
        $this->PalletModel = new PalletModel();
        
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
        $pallet_transfer_dt = $this->PalletTransferModel->getDatatable();
        $pallet_transfer_list = $pallet_transfer_dt->paginate($params['length'],'default',$params['page']);

        foreach ($pallet_transfer_list as $key => $pallet_transfer) {
            $pallet_status = $this->getPalletStatus($pallet_transfer);
            $pallet_transfer_list[$key]->status = $pallet_status['status'];
            $pallet_transfer_list[$key]->color_hex = $pallet_status['color_hex'];
        }
        $data_response = [
            'status' => 'success',
            'message' => 'Berhasil Mendapatkan Data Pallet Transfer',
            'data' => [
                'pallet_transfer_list' => $pallet_transfer_list
            ]
        ];
        
        return $this->respond($data_response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $pallet_serial_number = $this->request->getGet('pallet_serial_number');
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }


    private function getPalletStatus($pallet_data, $pill_mode = false)
    {
        
        if($pallet_data->flag_ready_to_transfer == 'N'){
            $status = 'Preparation in Progress';
            $color_hex = 'FFC107';
        } elseif($pallet_data->flag_ready_to_transfer == 'Y' && $pallet_data->flag_transferred == 'N'){
            $status = 'Ready to Transfer';
            $color_hex = '28A745';
        } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
            $status = 'Received at Warehouse';
            $color_hex = '17A2B8';
        } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
            $status = 'Loaded';
            $color_hex = '001F3F';
        } else {
            $status = 'Unknown Status';
            $color_hex = '6c757d';
        }
        
        return [
            'status' => $status,
            'color_hex' => $color_hex,
        ];
    }

    public function check_pallet_availability()
    {
        $pallet_serial_number = $this->request->getGet('pallet_serial_number');
        $pallet = $this->PalletModel->where('serial_number', $pallet_serial_number)->first();

        // ## Pallet Tidak ketemu => False
        if(!$pallet){
            $data_return = [
                'status' => 'error',
                'message' => 'Pallet Not Found',
            ];
            return $this->response->setJSON($data_return);
        }

        // ## Pallet sudah berisi => False
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

        // ## Pallet kosong dan belum pernah digunakan => True
        if( $pallet->flag_empty == 'Y' && $get_last_pallet_transfer == null 
            || $get_last_pallet_transfer->flag_transferred == 'Y' && $get_last_pallet_transfer->flag_loaded == 'Y'
        ){
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

        // ## Pallet sudah digunakan namun masih belum selesai sampai loading (belum bisa di gunakan kembali) => False
        if($get_last_pallet_transfer->flag_transferred == 'N' && $get_last_pallet_transfer->flag_loaded == 'N'){
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet Found',
                'data' => [
                    'pallet_status' => false,
                    'feedback_title' => 'Pallet is not Available!',
                    'feedback_message' => 'This Pallet has been used. Please Check on Pallet to Transfer List',
                ]
            ];
            return $this->response->setJSON($data_return);
        }
        
        $data_return = [
            'status' => 'success',
            'message' => 'Uncategorized!!',
            'data' => [
                'pallet_status' => false,
                'feedback_title' => 'Something Wrong!',
                'feedback_message' => 'Please contact the Developer',
            ]
        ];
        return $this->response->setJSON($data_return);
    }
}
