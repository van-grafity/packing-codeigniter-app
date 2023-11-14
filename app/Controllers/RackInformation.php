<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RackModel;
use App\Models\PalletModel;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;

use \Hermawan\DataTables\DataTable;

class RackInformation extends BaseController
{
    protected $RackModel;
    protected $PalletModel;
    protected $PalletTransferModel;
    protected $TransferNoteModel;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->RackModel = new RackModel();
        $this->PalletModel = new PalletModel();
        $this->PalletTransferModel = new PalletTransferModel();
        $this->TransferNoteModel = new TransferNoteModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Rack Information',
            'action_field_class' => '',
        ];
        
        return view('rackinformation/index', $data);
    }

    public function index_dt() 
    {
        $request_params = $this->request->getVar();
        $start = array_key_exists('start', $request_params) ? $request_params['start'] : 0;
        $length = array_key_exists('length', $request_params) ? $request_params['length'] : 2000;
        $page =  $start + 1;
        $draw = array_key_exists('draw', $request_params) ? $request_params['draw'] : 1;

        $params = [
            'length' => $length,
            'start' => $start,
            'page' => $page,
        ];

        $rack_list = $this->RackModel->getRackInformation_array($params);
        $dt_format = $this->reformat_to_dt_structure($rack_list, $draw);
        return $this->response->setJSON($dt_format);
    }


    public function reformat_to_dt_structure($rack_list, $draw)
    {
        $rack_list_array = $rack_list['rack_list'];
        
        foreach ($rack_list_array as $key => $rack) {
            if($rack->flag_empty == 'N') {
                $action_button = '
                <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="remove_pallet('. $rack->id .')">Remove Pallet</a>
                ';
            } else {
                $action_button = '';
            }

            $rack->DT_RowIndex = $key + 1;
            $rack->action = $action_button;
        }
        
        $result['draw'] = $draw;
        $result['recordsTotal'] = $rack_list['pager']->getTotal();
        $result['recordsFiltered'] = $rack_list['pager']->getTotal();
        $result['data'] = $rack_list_array;
        
        return $result;
    }

    public function remove_pallet()
    {
        /*
         * NOTE: This function. The Step : 
         * =================================================================
         * [] ambil informasi pallet transfer di dalam rack yang bersangkutan
         * [] harus check dulu apakah pallet sudah kosong, tidak boleh ada carton di atasnya (cartonbarcode.flag_loaded harus udah Y semua)
         * [] rack jadi kosong | tblrack.flag_empty => Y
         * [] rack pallet update tanggal keluar | tblrackpallet.outdate => date('Y-m-d H:i:s')
         * [] pallet transfer update status | tblpallettransfer.flag_loaded => Y
         * [] pallet jadi kosong | tblpallet.flag_empty => Y
         */

        $rack_id = $this->request->getGet('id');
        $pallet_transfer = $this->PalletTransferModel->getLastPalletTransferByRackID($rack_id);
        
        // ? (perlu dipertimbangkan lagi) : kayaknya di baris ini perlu check apakah pallet transfer ini sudah di load apa belum terlebih dahulu, kalau flag_loaded = 'Y' berarti tidak perlu lagi melanjutkan baris berikutnya. langsung return response aja

        $pallet = $this->PalletModel->find($pallet_transfer->pallet_id);
        $not_loaded_carton = $this->check_not_loaded_carton($pallet_transfer->id);
        
        if($not_loaded_carton) {
            $data_return = [
                'status' => 'error',
                'message' => 'All Carton must be loaded!',
                'data' => $not_loaded_carton,
            ];
            return $this->response->setJSON($data_return);
        }

        $this->RackModel->update($rack_id, ['flag_empty' => 'Y']);
        $update_last_rack_pallet = $this->RackModel->updateLastRackPallet($rack_id, ['out_date' => date('Y-m-d H:i:s')]);
        $update_pallet_transfer = $this->PalletTransferModel->update($pallet_transfer->id, ['flag_loaded' => 'Y']);
        $update_pallet = $this->PalletModel->update($pallet->id, ['flag_empty' => 'Y']);

        if($update_last_rack_pallet) {
            $data_return = [
                'status' => 'success',
                'message' => 'Pallet ' . $pallet->serial_number .' successfully removed from rack',
                'data' => $pallet,
            ];
            return $this->response->setJSON($data_return);
        }

    }

    private function check_not_loaded_carton($pallet_transfer_id)
    {
        $transfer_note_list = $this->PalletTransferModel->getTransferNotes($pallet_transfer_id);
        foreach ($transfer_note_list as $key => $transfer_note) {
            $not_loaded_carton = $this->TransferNoteModel->getCartonLoadStatusByTransfernote($transfer_note->id,'N');
            if($not_loaded_carton){
                return $not_loaded_carton; // ## artinya ada karton yang belum di load
            }
        }
        return false;
    }

















    // !! jangan lupa hapus bagian ini
    // public function detail()
    // {
    //     $rack_id = $this->request->getGet('id');
    //     $rack = $this->RackModel->find($rack_id);

    //     $data_return = [
    //         'status' => 'success',
    //         'message' => 'Successfully retrieved rack data',
    //         'data' => $rack,
    //     ];
    //     return $this->response->setJSON($data_return);
    // }

    // public function save()
    // {
    //     $data = array(
    //         'serial_number' => $this->request->getVar('serial_number'),
    //         'description'   => $this->request->getVar('description'),
    //     );
    //     $this->RackModel->save($data);
    //     return redirect()->to('rack')->with('success', "Successfully added Rack");
    // }

    // public function update()
    // {
    //     $id = $this->request->getVar('edit_rack_id');
    //     $data = array(
    //         'serial_number' => $this->request->getVar('serial_number'),
    //         'description'   => $this->request->getVar('description'),
    //     );

    //     $this->RackModel->update($id, $data);
    //     return redirect()->to('rack')->with('success', "Successfully updated Rack");
    // }

    // public function delete()
    // {
    //     $id = $this->request->getVar('rack_id');
    //     $this->RackModel->delete($id);
    //     return redirect()->to('rack')->with('success', "Successfully deleted Rack");
    // }
    
}

