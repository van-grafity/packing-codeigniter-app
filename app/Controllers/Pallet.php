<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PalletModel;
use App\Models\FactoryModel;
use \Hermawan\DataTables\DataTable;

class Pallet extends BaseController
{
    protected $PalletModel;
    protected $FactoryModel;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->PalletModel = new PalletModel();
        $this->FactoryModel = new FactoryModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Pallet List',
            'action_field_class' => '',
        ];
        
        return view('pallet/index', $data);
    }

    public function index_dt() 
    {
        $pallet_list = $this->PalletModel->getDatatable();
        return DataTable::of($pallet_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="edit_pallet('. $row->id .')">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_pallet('. $row->id .')">Delete</a>
                ';
                return $action_button;
            })->toJson(true);
    }

    public function detail()
    {
        $pallet_id = $this->request->getGet('id');
        $pallet = $this->PalletModel->find($pallet_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Succesfully retrieved carton',
            'data' => $pallet,
        ];
        return $this->response->setJSON($data_return);
    }

    public function save()
    {
        $data = array(
            'serial_number' => $this->request->getVar('serial_number'),
            'description'   => $this->request->getVar('description'),
            'flag_empty'    => 'Y',
        );
        $this->PalletModel->save($data);
        return redirect()->to('pallet')->with('success', "Successfully added Pallet");
    }

    public function update()
    {
        $id = $this->request->getVar('edit_pallet_id');
        $data = array(
            'serial_number' => $this->request->getVar('serial_number'),
            'description'   => $this->request->getVar('description'),
            'flag_empty'    => 'Y'
        );

        $this->PalletModel->updatePallet($data, $id);
        return redirect()->to('pallet')->with('success', "Successfully updated Pallet");
    }

    public function delete()
    {
        $id = $this->request->getVar('pallet_id');
        $this->PalletModel->deletePallet($id);
        return redirect()->to('pallet')->with('success', "Successfully deleted Pallet");
    }
}

