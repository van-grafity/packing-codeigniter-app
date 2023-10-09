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
        $rack_list = $this->RackModel->getRackInformation();
        return DataTable::of($rack_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="edit_rack('. $row->id .')">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_rack('. $row->id .')">Delete</a>
                ';
                return $action_button;
            })->add('gl_number', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return '62309-00';

            })->add('po_number', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return '8XW8FHBM';

            })->add('colour', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return 'Med Heather Grey';

            })->add('buyer', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return 'AERO';

            })->add('total_carton', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return 10;

            })->add('total_pcs', function($row) use ($PalletTransferModel, $TransferNoteModel) {
                
                return 100;

            })->add('status', function($row){
                $pill_element = '';
                if($row->flag_empty == 'Y') {
                    $pill_element = '<span class="badge badge-success">Empty</span>';
                } else {
                    $pill_element = '<span class="badge badge-warning">Not Empty</span>';
                }
                return $pill_element;
            })->filter(function ($builder, $request) {
                
                if ($request->rack_status){
                    $builder->where('flag_empty', $request->rack_status);
                }
                
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

