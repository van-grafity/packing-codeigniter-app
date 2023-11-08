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
        $level_options = [1,2,3];
        $area_options = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O','P', 'Q', 'R', 'S', 'T', 'U'];

        $data = [
            'title' => 'Rack List',
            'action_field_class' => '',
            'level_options' => $level_options,
            'area_options' => $area_options,
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
            })->edit('area', function($row){
                return 'Area '.$row->area;
            })->edit('level', function($row){
                return 'Level '.$row->level;
            })->add('status', function($row){
                $pill_element = '';
                if($row->flag_empty == 'Y') {
                    $pill_element = '<span class="badge badge-success">Empty</span>';
                } else {
                    $pill_element = '<span class="badge badge-warning">Not Empty</span>';
                }
                return $pill_element;
            })->filter(function ($builder, $request) {
                
                if ($request->filter_area)
                    $builder->where('area', $request->filter_area);
                if ($request->filter_level)
                    $builder->where('level', $request->filter_level);
                if ($request->filter_status)
                    $builder->where('flag_empty', $request->filter_status);

            })->toJson(true);
    }

    public function detail()
    {
        $rack_id = $this->request->getGet('id');
        $rack = $this->RackModel->find($rack_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved rack data',
            'data' => $rack,
        ];
        return $this->response->setJSON($data_return);
    }

    public function save()
    {
        $data = array(
            'serial_number' => $this->request->getVar('serial_number'),
            'area' => $this->request->getVar('area'),
            'level' => $this->request->getVar('level'),
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
            'area' => $this->request->getVar('area'),
            'level' => $this->request->getVar('level'),
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

