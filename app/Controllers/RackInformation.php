<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RackModel;
use App\Models\PalletTransferModel;
use App\Models\TransferNoteModel;

use \Hermawan\DataTables\DataTable;

class RackInformation extends BaseController
{
    protected $RackModel;
    protected $PalletTransferModel;
    protected $TransferNoteModel;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->RackModel = new RackModel();
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
        $PalletTransferModel = $this->PalletTransferModel;
        $TransferNoteModel = $this->TransferNoteModel;
        

        $request_params = $this->request->getVar();
        
        // dd($request_params);
        
        $start = array_key_exists('start', $request_params) ? $request_params['start'] : 0;
        $length = array_key_exists('length', $request_params) ? $request_params['length'] : 100;
        $page =  $start + 1;
        $draw = array_key_exists('draw', $request_params) ? $request_params['draw'] : 1;

        $params = [
            'length' => $length,
            'start' => $start,
            'page' => $page,
        ];

        $rack_list = $this->RackModel->getRackInformation_array($params);

        $json_format = $this->reformat_data_structure($rack_list, $draw);
        return $this->response->setJSON($json_format);
    }


    public function reformat_data_structure($rack_list, $draw)
    {
        $rack_list_array = $rack_list['rack_list'];
        foreach ($rack_list_array as $key => $rack) {
            $rack->DT_RowIndex = $key + 1;
        }
        
        $result['draw'] = $draw;
        $result['recordsTotal'] = $rack_list['pager']->getTotal();
        $result['recordsFiltered'] = $rack_list['pager']->getTotal();
        $result['data'] = $rack_list_array;
        
        return $result;
    }

    public function detail()
    {
        $rack_id = $this->request->getGet('id');
        $rack = $this->RackModel->find($rack_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton',
            'data' => $rack,
        ];
        return $this->response->setJSON($data_return);
    }

    public function save()
    {
        $data = array(
            'serial_number' => $this->request->getVar('serial_number'),
            'description'   => $this->request->getVar('description'),
        );
        $this->RackModel->save($data);
        return redirect()->to('rack')->with('success', "Successfully added Rack");
    }

    public function update()
    {
        $id = $this->request->getVar('edit_rack_id');
        $data = array(
            'serial_number' => $this->request->getVar('serial_number'),
            'description'   => $this->request->getVar('description'),
        );

        $this->RackModel->update($id, $data);
        return redirect()->to('rack')->with('success', "Successfully updated Rack");
    }

    public function delete()
    {
        $id = $this->request->getVar('rack_id');
        $this->RackModel->delete($id);
        return redirect()->to('rack')->with('success', "Successfully deleted Rack");
    }
}

