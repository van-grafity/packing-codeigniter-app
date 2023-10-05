<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RackModel;
use \Hermawan\DataTables\DataTable;

class Rack extends BaseController
{
    protected $RackModel;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->RackModel = new RackModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Rack List',
            'action_field_class' => '',
        ];
        
        return view('rack/index', $data);
    }

    public function index_dt() 
    {
        $rack_list = $this->RackModel->getDatatable();
        return DataTable::of($rack_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="edit_rack('. $row->id .')">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_rack('. $row->id .')">Delete</a>
                ';
                return $action_button;
            })->toJson(true);
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
            'location'   => $this->request->getVar('location'),
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
            'location'   => $this->request->getVar('location'),
        );

        $this->RackModel->updateRack($data, $id);
        return redirect()->to('rack')->with('success', "Successfully updated Rack");
    }

    public function delete()
    {
        $id = $this->request->getVar('rack_id');
        $this->RackModel->deleteRack($id);
        return redirect()->to('rack')->with('success', "Successfully deleted Rack");
    }
}

