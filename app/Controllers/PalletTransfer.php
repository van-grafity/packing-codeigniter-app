<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;
use App\Models\PalletModel;
use App\Models\CartonBarcodeModel;
use App\Models\LocationModel;
use App\Models\TransferNoteDetailModel;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class PalletTransfer extends BaseController
{
    protected $PalletTransferModel;
    protected $TransferNoteModel;
    protected $PalletModel;
    protected $CartonBarcodeModel;
    protected $LocationModel;
    protected $TransferNoteDetailModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->TransferNoteModel = new TransferNoteModel();
        $this->TransferNoteDetailModel = new TransferNoteDetailModel();
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

                if($row->flag_ready_to_transfer == 'Y'){
                    $action_button = '
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-1 disabled">Edit</a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1 disabled">Delete</a>
                    ';
                } else {
                    $action_button = '
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-1" onclick="edit_pallet_transfer('. $row->id .')">Edit</a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1" onclick="delete_pallet_transfer('. $row->id .')">Delete</a>
                    ';
                }

                $action_button .= '
                    <a href="'. url_to('pallet_transfer_transfer_note',$row->id) .'" class="btn btn-info btn-sm mb-1">Detail</a>
                ';
                return $action_button;
            })->edit('transaction_number', function($row){
                $transaction_number = '<a href="'. base_url('pallet-transfer/').$row->id.'/transfer-note">'.$row->transaction_number .'</a>';
                return $transaction_number;

            })->add('transfer_note', function($row){
                $transfer_note_result = '';
                $transfer_note_list = $this->TransferNoteModel->where('pallet_transfer_id', $row->id)->findAll();
                
                foreach ($transfer_note_list as $key => $transfer_note) {
                    $transfer_note_pill ='<a href="'. url_to('pallet_transfer_transfer_note_print',$transfer_note->id) .'" class="btn btn-sm bg-info mb-1" target="_blank" data-toggle="tooltip" data-placement="top" title="Click to Print">'. $transfer_note->serial_number .'</a>'; 
                    $transfer_note_result = $transfer_note_result . ' ' . $transfer_note_pill;
                }
                
                return $transfer_note_result;
            })->add('status', function($row){
                
                $status = $this->getPalletStatus($row, true);
                return $status;

            })->postQuery(function ($pallet_list) {
                $pallet_list->orderBy('tblpallettransfer.created_at', 'DESC');
            })->toJson(true);
    }

    // !! fungsi ini kayaknya ga kepake, berikut view pallettransfer/create.php nya
    // public function create()
    // {
    //     $data = [
    //         'title' => 'New Pallet Transfer',
    //     ];
    //     // return view('pallettransfer/create', $data);
        
    // }

    public function store()
    {
        $data_input = $this->request->getPost();
        $pallet = $this->PalletModel->where('serial_number', $data_input['pallet_serial_number'])->first();
        
        $pallet_transfer_this_month = $this->PalletTransferModel->countPalletTransferThisMonth();
        $next_number = $pallet_transfer_this_month + 1;
        
        $data = array(
            'transaction_number' => $this->generate_transaction_number($next_number),
            'location_from_id' => $data_input['location_from'],
            'location_to_id' => $data_input['location_to'],
            'pallet_id' => $pallet->id,
            'flag_transferred' => 'N',
            'flag_loaded' => 'N',
        );
        
        $this->PalletTransferModel->save($data);
        return redirect()->to('pallet-transfer')->with('success', "Successfully added Data");
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
        return redirect()->to('pallet-transfer')->with('success', "Successfully updated Data");
    }

    public function delete()
    {
        $pallet_transfer_id = $this->request->getPost('pallet_transfer_id');
        $is_transfered = $this->PalletTransferModel->isTransferred($pallet_transfer_id);
        
        if($is_transfered) {
            return redirect()->to('pallet-transfer')->with('error', "Can't delete. This Pallet has been transferred to FG Warehouse");
        }
        
        try {
            $this->PalletTransferModel->transException(true)->transStart();
            $delete_data = $this->PalletTransferModel->deletePalletTransfer($pallet_transfer_id);
            $this->PalletTransferModel->transComplete();
            
            return redirect()->to('pallet-transfer')->with('success', "Successfully deleted Data");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function transfer_note($pallet_transfer_id)
    {
        $pallet_transfer = $this->PalletTransferModel->getData($pallet_transfer_id);
        $pallet_transfer->status = $this->getPalletStatus($pallet_transfer);
        
        $btn_transfer_note_class = '';

        if($pallet_transfer->flag_ready_to_transfer == 'Y'){
            $btn_transfer_note_class = 'disabled';
        }

        $transfer_note_list = $this->PalletTransferModel->getTransferNotesByPalletTransfer($pallet_transfer->id);

        array_walk($transfer_note_list, function (&$item, $key) {
            if($item->received_at){
                $received_datetime = new Time($item->received_at);
                $received_datetime = $received_datetime->toLocalizedString('dd MMMM yyyy, HH:mm');
                $item->received_at = $received_datetime;
            }
        });
        
        $data = [
            'title' => 'Packing Transfer Note',
            'pallet_transfer' => $pallet_transfer,
            'btn_transfer_note_class' => $btn_transfer_note_class,
            'transfer_note_list' => $transfer_note_list,
        ];
        return view('pallettransfer/detail', $data);
    }

    // !! ini juga kayaknya ga di pakai
    // public function pallet_detail()
    // {
    //     $pallet_serial_number = $this->request->getGet('pallet_serial_number');
        
    //     $pallet = $this->PalletModel->where('serial_number', $pallet_serial_number)->first();
    //     if(!$pallet){
    //         $data_return = [
    //             'status' => 'error',
    //             'message' => 'Pallet Not Found',
    //         ];
    //         return $this->response->setJSON($data_return);
    //     }
        
    //     $get_pallet_transfer = $this->PalletTransferModel->getDetailPalletBySerialNumber($pallet_serial_number);
        
    //     $pallet_data = [
    //         'pallet_number' => $get_pallet_transfer->pallet_number,
    //         'location_from' => $get_pallet_transfer->location_from ? $get_pallet_transfer->location_from : '-',
    //         'location_to' => $get_pallet_transfer->location_to ? $get_pallet_transfer->location_to : '-',
    //     ];
    //     $transfer_note_list = [];
        
    //     if($get_pallet_transfer->flag_empty == 'Y'){
    //         $pallet_data['status'] = 'Empty';
    //     } else {
    //         $pallet_data['status'] = $this->getPalletStatus($get_pallet_transfer);
    //         $transfer_note_list = $this->PalletTransferModel->getTransferNotesByPalletTransfer($get_pallet_transfer->id);
    //     }

    //     $data_return = [
    //         'status' => 'success',
    //         'message' => 'Pallet Found',
    //         'data' => [
    //             'pallet_info' => $pallet_data,
    //             'transfer_note_list' => $transfer_note_list,
    //         ],
    //     ];
    //     return $this->response->setJSON($data_return);

    // }

    public function transfer_note_store()
    {
        $data_input = $this->request->getPost();
        
        $transfer_note_this_month = $this->TransferNoteModel->countTransferNoteThisMonth();
        $next_number = $transfer_note_this_month + 1;
        
        $transfer_note_data = [
            'pallet_transfer_id' => $data_input['pallet_transfer_id'],
            'serial_number' => $this->generate_serial_number($next_number),
            'issued_by' => $data_input['transfer_note_issued_by'],
            'authorized_by' => $data_input['transfer_note_authorized_by'],
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

        
        return redirect()->to("pallet-transfer/" . $data_input['pallet_transfer_id'] . "/transfer-note")->with('success', "Successfully added Transfer Note");
    }

    public function transfer_note_update()
    {
        $data_input = $this->request->getPost();
        $transfer_note_id = $data_input['edit_transfer_note_id'];
        $transfer_note_data = [
            'issued_by' => $data_input['transfer_note_issued_by'],
            'authorized_by' => $data_input['transfer_note_authorized_by'],
        ];

        try {
            $this->PalletTransferModel->transException(true)->transStart();
            $this->TransferNoteModel->update($transfer_note_id, $transfer_note_data);
            
            $delete_transfer_note_detail = $this->TransferNoteDetailModel->where('transfer_note_id', $transfer_note_id)->delete();
            if(array_key_exists("carton_barcode_id",$data_input)){
                $this->TransferNoteDetailModel->transException(true)->transStart();
                foreach($data_input['carton_barcode_id'] as $key => $carton_barcode_id){
                    $this->TransferNoteDetailModel->insert(['transfer_note_id' => $transfer_note_id, 'carton_barcode_id' => $carton_barcode_id ]);
                }
                $this->TransferNoteDetailModel->transComplete();
            }
    
            $this->PalletTransferModel->transComplete();
            
            return redirect()->to("pallet-transfer/" . $data_input['pallet_transfer_id'] . "/transfer-note")->with('success', "Successfully updated Transfer Note");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function transfer_note_delete()
    {
        $data_input = $this->request->getPost();
        
        $transfer_note_id = $data_input['delete_transfer_note_id'];
        $pallet_transfer_id = $data_input['transfer_note_pallet_transfer_id'];
        $pallet_transfer = $this->PalletTransferModel->find($pallet_transfer_id);
        
        try {
            $this->TransferNoteModel->transException(true)->transStart();
            $delete_data = $this->TransferNoteModel->deleteTransferNote($transfer_note_id);
            $this->TransferNoteModel->transComplete();

            // ## check transfer note in pallet transfer
            $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer_id);
            if(empty($transfer_note_list)) {
                $this->PalletModel->update($pallet_transfer->pallet_id, ['flag_empty' => 'Y']);
            }
            
            return redirect()->to("pallet-transfer/" . $pallet_transfer_id . "/transfer-note")->with('success', "Successfully deleted Transfer Note");
        } catch (\Throwable $th) {
            throw $th;
        }
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

        $transfer_note_detail = $this->TransferNoteModel->getCartonInTransferNote($transfer_note->id);
        $data_return = [
            'status' => 'success',
            'message' => 'Carton Found',
            'data' => [
                'transfer_note' => $transfer_note,
                'transfer_note_detail' => $transfer_note_detail,
            ],
        ];
        return $this->response->setJSON($data_return);
    }

    public function carton_detail()
    {
        $carton_barcode = $this->request->getGet('carton_barcode');
        
        $is_carton_available = $this->TransferNoteModel->isCartonAvailable($carton_barcode);
        
        if(!$is_carton_available){
            $data_return = [
                'status' => 'error',
                'message' => 'This Carton Has Already in Other Transfer Note',
            ];
            return $this->response->setJSON($data_return);
        }

        $carton_info = $this->CartonBarcodeModel->getCartonInfoByBarcode_v2($carton_barcode);
        
        if(!$carton_info){
            $data_return = [
                'status' => 'error',
                'message' => 'Carton Not Found!',
            ];
            return $this->response->setJSON($data_return);
        }

        if($carton_info->flag_packed == "N"){
            $data_return = [
                'status' => 'error',
                'message' => 'This Carton Has not Packing Yet',
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

    public function transfer_note_print($transfer_note_id)
    {
        $total_all_carton = 0;
        $total_all_pcs = 0;

        $transfer_note = $this->TransferNoteModel->getPackingTransferNote($transfer_note_id);
        $transfer_note_detail = $this->TransferNoteModel->getTransferNoteDetail($transfer_note_id);
        foreach ($transfer_note_detail as $key => $detail) {
            $transfer_note_detail[$key]->total_detail = count($detail->carton_content);
            $total_all_carton += $detail->total_carton;
            $total_all_pcs += $detail->total_pcs;
        }
        
        $transfer_note->total_all_carton = $total_all_carton;
        $transfer_note->total_all_pcs = $total_all_pcs;
        
        $filename = 'Packing Transfer Note - ' . $transfer_note->transfer_note_number;

        $data = [
            'title'         => $filename,
            'date_printed'  => datetime_indo(),
            'transfer_note' => $transfer_note,
            'transfer_note_detail' => $transfer_note_detail,
        ];
        // dd($data);
        
        // return view('pallettransfer/packing_transfer_note_pdf', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('pallettransfer/packing_transfer_note_pdf', $data));
        // $dompdf->setPaper('A4', 'portrait');
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => false]);
    }

    public function complete_preparation()
    {
        $pallet_transfer_id = $this->request->getGet('pallet_transfer_id');

        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer_id);
        if(empty($transfer_note_list)) {
            $data_return = [
                'status' => 'error',
                'message' => 'Cannot Update Pallet status',
                'data' => [
                    'message_text' => 'Please provide at least 1 Packing Transfer Note'
                ]
            ];
            return $this->response->setJSON($data_return);
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
        return $this->response->setJSON($data_return);
    }

    public function getPalletStatus($pallet_data, $pill_mode = false)
    {
        if($pill_mode){
            if($pallet_data->flag_ready_to_transfer == 'N'){
                $status = '<span class="badge badge-warning">Preparation in Progress</span>';
            } elseif($pallet_data->flag_ready_to_transfer == 'Y' && $pallet_data->flag_transferred == 'N'){
                $status = '<span class="badge badge-success">Ready to Transfer</span>';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
                $status = '<span class="badge badge-info">Received at Warehouse</span>';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
                $status = '<span class="badge bg-navy">Loaded</span>';
            } else {
                $status = '<span class="badge badge-danger">Unknown Status</span>';
            }
        } else {
            if($pallet_data->flag_ready_to_transfer == 'N'){
                $status = 'Preparation in Progress';
            } elseif($pallet_data->flag_ready_to_transfer == 'Y' && $pallet_data->flag_transferred == 'N'){
                $status = 'Ready to Transfer';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
                $status = 'Received at Warehouse';
            } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
                $status = 'Loaded';
            } else {
                $status = 'Unknown Status';
            }
        }
        // if($pill_mode){
        //     if($pallet_data->flag_transferred == 'N' && $pallet_data->flag_loaded == 'N'){
        //         $status = '<span class="badge badge-secondary">Not Transferred Yet</span>';
        //     } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
        //         $status = '<span class="badge badge-info">at Warehouse</span>';
        //     } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
        //         $status = '<span class="badge badge-success">Loaded</span>';
        //     } else {
        //         $status = '<span class="badge badge-danger">Unknown Status</span>';
        //     }
        // } else {
        //     if($pallet_data->flag_transferred == 'N' && $pallet_data->flag_loaded == 'N'){
        //         $status = 'Not Transferred Yet';
        //     } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'N'){
        //         $status = 'at Warehouse';
        //     } elseif($pallet_data->flag_transferred == 'Y' && $pallet_data->flag_loaded == 'Y'){
        //         $status = 'Loaded';
        //     } else {
        //         $status = 'Unknown Status';
        //     }
        // }
        return $status;
    }

    private function generate_serial_number($number)
    {
        // ## Packing Transfer Note Serial Number
        $serial_number = 'PTN-' . date('ym') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        return $serial_number;
    }
    
    private function generate_transaction_number($number)
    {
        // ## Pallet Transfer Transaction Number
        $serial_number = 'PTRF-' . date('ym') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        return $serial_number;
    }
}
