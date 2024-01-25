<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PalletTransferModel;
use App\Models\CartonBarcodeModel;
use App\Models\TransferNoteModel;
use App\Models\TransferNoteDetailModel;
use App\Models\PalletModel;

use CodeIgniter\I18n\Time;

class PalletTransferController extends ResourceController
{
    use ResponseTrait;

    protected $PalletTransferModel;
    protected $CartonBarcodeModel;
    protected $TransferNoteModel;
    protected $TransferNoteDetailModel;
    protected $PalletModel;

    public function __construct()
    {
        $this->PalletTransferModel = new PalletTransferModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->TransferNoteDetailModel = new TransferNoteDetailModel();
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
        $search = $this->request->getGet('search') ? $this->request->getGet('search') : null;
        
        $pallet_transfer_dt = $this->PalletTransferModel->getDatatable();
        $pallet_transfer_list = $pallet_transfer_dt
            ->when($search, static function ($query, $search) {
                $query->like('transaction_number', '%'.$search.'%')
                      ->orLike('pallet.serial_number', '%'.$search.'%');
            })->orderBy('tblpallettransfer.created_at', 'DESC')->paginate($params['length'],'default',$params['page']);

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
    public function show($pallet_transfer_id = null)
    {
        $pallet_transfer = $this->PalletTransferModel->getData($pallet_transfer_id);
        
        $pallet_status = $this->getPalletStatus($pallet_transfer);
        $pallet_transfer->status = $pallet_status['status'];
        $pallet_transfer->color_hex = $pallet_status['color_hex'];

        $transfer_note_list = $this->PalletTransferModel->getTransferNotesByPalletTransfer($pallet_transfer->id);
        array_walk($transfer_note_list, function (&$item, $key) {
            if($item->received_at){
                $received_datetime = new Time($item->received_at);
                $received_datetime = $received_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
                $item->received_at = $received_datetime;
            }
            if($item->created_at){
                $created_datetime = new Time($item->created_at);
                $created_datetime = $created_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
                $item->created_at = $created_datetime;
            }
        });
        
        $data = [
            'pallet_transfer' => $pallet_transfer,
            'transfer_note_list' => $transfer_note_list,
        ];

        $data_response = [
            'status' => 'success',
            'message' => 'Berhasil Mendapatkan Data Pallet Transfer Detail',
            'data' => [
                'data' => $data
            ]
        ];
        
        return $this->respond($data_response);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data_input = $this->request->getPost();
        
        // ## parameters validation
        $params_to_check = ['pallet_serial_number','location_from','location_to'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_return, 404);
        }

        $response = $this->pallet_availability($data_input['pallet_serial_number']);
        if($response['status_code'] != 200) {
            return $this->respond($response['data_return'], $response['status_code']);
        }

        $pallet = $this->PalletModel->where('serial_number', $data_input['pallet_serial_number'])->first();

        $pallet_transfer_this_month = $this->PalletTransferModel->countPalletTransferThisMonth();
        $next_number = $pallet_transfer_this_month + 1;

        $data = array (
            'transaction_number' => $this->PalletTransferModel->generate_transaction_number($next_number),
            'location_from_id' => $data_input['location_from'],
            'location_to_id' => $data_input['location_to'],
            'pallet_id' => $pallet->id,
            'flag_transferred' => 'N',
            'flag_loaded' => 'N',
        );
        
        $this->PalletTransferModel->transException(true)->transStart();
        $this->PalletTransferModel->save($data);
        $this->PalletTransferModel->transComplete();
        
        $pallet_transfer_id = $this->PalletTransferModel->getInsertID();
        $pallet_transfer = $this->PalletTransferModel->getPalletTransfer($pallet_transfer_id);

        $data_response = [
            'status' => 'success',
            'message' => 'Berhasil Menambahkan Data Pallet Transfer',
            'data' => [
                'pallet_transfer' => $pallet_transfer
            ]
        ];
        
        return $this->respond($data_response, 201);
    }

    public function search_carton()
    {
        $data_input = $this->request->getGet();

        // ## parameters validation
        $params_to_check = ['carton_barcode'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response);
        }

        $carton_barcode = $this->request->getGet('carton_barcode');
        $is_carton_available = $this->TransferNoteModel->isCartonAvailable($carton_barcode);
        
        if(!$is_carton_available){
            $data_return = [
                'status' => 'error',
                'message' => 'This Carton Has Already in Other Transfer Note',
            ];
            return $this->respond($data_return);
        }

        $carton_info = $this->CartonBarcodeModel->getCartonInfoByBarcode_v2($carton_barcode);
        
        if(!$carton_info){
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found!',
            ];
            return $this->respond($data_return);
        }

        if($carton_info->flag_packed == "N"){
            $data_return = [
                'status' => 'error',
                'message' => 'This Carton Has not Packing Yet',
            ];
            return $this->respond($data_return);
        }

        $size_list_in_carton = $this->CartonBarcodeModel->getCartonContent($carton_info->carton_id);
        $carton_info->content = $this->CartonBarcodeModel->serialize_size_list($size_list_in_carton);
        $carton_info->total_pcs = array_sum(array_column($size_list_in_carton,'qty'));
        
        $data_return = [
            'status' => 'success',
            'message' => 'Carton Found',
            'data' => $carton_info,
        ];
        return $this->respond($data_return);
    }

    public function transfer_note_store()
    {
        $data_input = $this->request->getPost();

        // ## parameters validation
        $params_to_check = ['pallet_transfer_id','carton_barcode_id'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response);
        }
        
        $transfer_note_this_month = $this->TransferNoteModel->countTransferNoteThisMonth();
        $next_number = $transfer_note_this_month + 1;
        
        $transfer_note_data = [
            'pallet_transfer_id' => $data_input['pallet_transfer_id'],
            'serial_number' => $this->PalletTransferModel->generate_serial_number($next_number),
        ];

        $this->TransferNoteModel->transException(true)->transStart();
        $transfer_note_id = $this->TransferNoteModel->insert($transfer_note_data);
        
        if(array_key_exists("carton_barcode_id",$data_input)){
            $this->TransferNoteDetailModel->transException(true)->transStart();
            foreach($data_input['carton_barcode_id'] as $key => $carton_barcode_id){
                $this->TransferNoteDetailModel->insert(['transfer_note_id' => $transfer_note_id, 'carton_barcode_id' => $carton_barcode_id ]);
            }
            $this->TransferNoteDetailModel->transComplete();
        }

        $this->TransferNoteModel->transComplete();

        // ## update status pallet
        $pallet_transfer = $this->PalletTransferModel->find($data_input['pallet_transfer_id']);
        $this->PalletModel->update($pallet_transfer->pallet_id, ['flag_empty' => 'N']);

        $transfer_note = $this->TransferNoteModel->getPackingTransferNote($transfer_note_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Berhasil Menambahkan Transfer Note',
            'data' => [
                'transfer_note' => $transfer_note,
                'pallet_transfer_id' => $data_input['pallet_transfer_id']
            ],
        ];
        return $this->respond($data_return, 201);
    }

    public function transfer_note_edit($transfer_note_id = null)
    {
        $transfer_note = $this->TransferNoteModel->getPackingTransferNote($transfer_note_id);
        $created_datetime = new Time($transfer_note->created_at);
        $transfer_note->created_at = $created_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
        
        if(!$transfer_note){
            $data_return = [
                'status' => 'error',
                'message' => 'Transfer Note Not Found',
            ];
            return $this->respond($data_return, 404);
        }

        $transfer_note_detail = $this->TransferNoteModel->getCartonInTransferNote($transfer_note->transfer_note_id);
        $data_return = [
            'status' => 'success',
            'message' => 'Transfer Note Found',
            'data' => [
                'transfer_note' => $transfer_note,
                'transfer_note_detail' => $transfer_note_detail,
            ],
        ];
        return $this->respond($data_return);

    }

    public function transfer_note_update()
    {
        $data_input = $this->request->getRawInput();
        
        // ## parameters validation
        $params_to_check = ['pallet_transfer_id','transfer_note_id'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response, 404);
        }
        
        $transfer_note_id = $data_input['transfer_note_id'];
        // $transfer_note_data = [
        //     'issued_by' => $data_input['transfer_note_issued_by'],
        //     'authorized_by' => $data_input['transfer_note_authorized_by'],
        // ];

        try {
            $this->PalletTransferModel->transException(true)->transStart();
            // $this->TransferNoteModel->update($transfer_note_id, $transfer_note_data);
            
            $delete_transfer_note_detail = $this->TransferNoteDetailModel->where('transfer_note_id', $transfer_note_id)->delete();
            if(array_key_exists("carton_barcode_id",$data_input)){
                $this->TransferNoteDetailModel->transException(true)->transStart();
                foreach($data_input['carton_barcode_id'] as $key => $carton_barcode_id){
                    $this->TransferNoteDetailModel->insert(['transfer_note_id' => $transfer_note_id, 'carton_barcode_id' => $carton_barcode_id ]);
                }
                $this->TransferNoteDetailModel->transComplete();
            }
    
            $this->PalletTransferModel->transComplete();


            $transfer_note = $this->TransferNoteModel->getPackingTransferNote($transfer_note_id);
            $created_datetime = new Time($transfer_note->created_at);
            $transfer_note->created_at = $created_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
    
            $transfer_note_detail = $this->TransferNoteModel->getCartonInTransferNote($transfer_note_id);
    
            $data_return = [
                'status' => 'success',
                'message' => 'Transfer Berhasil diperbaharui',
                'data' => [
                    'transfer_note' => $transfer_note,
                    'transfer_note_detail' => $transfer_note_detail,
                    'pallet_transfer_id' => $data_input['pallet_transfer_id']
                ],
            ];
            return $this->respond($data_return);
            
        } catch (\Throwable $th) {
            $data_return = [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
            return $this->respond($data_return, 500);
        }
    }


    // !! bisa di hapus untuk function yang tidak di perlukan
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


    public function getPalletStatus($pallet_data, $pill_mode = false)
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
        $data_input = $this->request->getGet();

        // ## parameters validation
        $params_to_check = ['pallet_serial_number'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response);
        }

        $pallet_serial_number = $this->request->getGet('pallet_serial_number');

        $response = $this->pallet_availability($pallet_serial_number);
        return $this->respond($response['data_return'], $response['status_code']);
    }

    public function pallet_availability($pallet_serial_number = null)
    {
        if(!$pallet_serial_number){
            $response = [
                'data_return' => [
                    'status' => 'error',
                    'message' => 'Please Provide Pallet Serial Number',
                ],
                'status_code' => 400,
            ];
            return $response;
        }

        $pallet = $this->PalletModel->where('serial_number', $pallet_serial_number)->first();
        
        // ## Pallet Tidak ketemu => False
        if(!$pallet){
            $response = [
                'data_return' => [
                    'status' => 'error',
                    'message' => 'Pallet Not Found',
                ],
                'status_code' => 404,
            ];
            return $response;
        }
        
        // ## Pallet sudah berisi => False
        if($pallet->flag_empty == 'N') {
            $response = [
                'data_return' => [
                    'status' => 'error',
                    'message' => 'Pallet is not Available. This Pallet has not empty',
                ],
                'status_code' => 404,
            ];
            return $response;
        }

        $get_last_pallet_transfer = $this->PalletTransferModel->getLastPalletTransferByPalletID($pallet->id);

        // ## Pallet kosong dan belum pernah digunakan => True
        if( $pallet->flag_empty == 'Y' && $get_last_pallet_transfer == null 
            || $get_last_pallet_transfer->flag_transferred == 'Y' && $get_last_pallet_transfer->flag_loaded == 'Y'
        ){
            $response = [
                'data_return' => [
                    'status' => 'success',
                    'message' => 'Pallet is Available',
                    'data' => [
                        'pallet_serial_number' => $pallet_serial_number
                    ],
                ],
                'status_code' => 200,
            ];
            return $response;
        }

        // ## Pallet sudah digunakan namun masih belum selesai sampai loading (belum bisa di gunakan kembali) => False
        if($get_last_pallet_transfer->flag_transferred == 'N' && $get_last_pallet_transfer->flag_loaded == 'N'){
            $response = [
                'data_return' => [
                    'status' => 'error',
                    'message' => 'This Pallet has been used. Please Check on Pallet to Transfer List',
                ],
                'status_code' => 400,
            ];
            return $response;
        }

        // ## Unknown Condition
        $response = [
            'data_return' => [
                'status' => 'error',
                'message' => 'Something Wrong. Please contact the Developer!',
            ],
            'status_code' => 400,
        ];
        return $response;
    }


    public function complete_preparation()
    {
        $data_input = $this->request->getPost();

        // ## parameters validation
        $params_to_check = ['pallet_transfer_id'];
        $missingAttributes = array_has_attributes($data_input, $params_to_check);
        
        if (!empty($missingAttributes)) {
            $data_response = [
                'status' => 'error',
                'message' => 'Atribut ' . implode(', ', $missingAttributes) . ' tidak ditemukan!',
            ];
            return $this->respond($data_response);
        }
        $pallet_transfer_id = $data_input['pallet_transfer_id'];

        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer_id);
        if(empty($transfer_note_list)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Cannot Update Pallet status',
                'data' => [
                    'message_text' => 'Please provide at least 1 Packing Transfer Note'
                ]
            ];
            return $this->respond($data_return, 400);
        }

        $pallet_transfer = $this->PalletTransferModel
            ->join('tblpallet as pallet','pallet.id = tblpallettransfer.pallet_id')
            ->where('tblpallettransfer.id', $pallet_transfer_id)
            ->select('tblpallettransfer.*, pallet.serial_number as pallet_serial_number')
            ->first();

        $this->PalletTransferModel->update($pallet_transfer_id, ['flag_ready_to_transfer' => 'Y', 'ready_to_transfer_at' => date('Y-m-d H:i:s')]);

        $data_return = [
            'status' => 'success',
            'message' => 'Successfully update Status Pallet',
            'data' => $pallet_transfer
        ];
        return $this->respond($data_return, 200);
    }
}
