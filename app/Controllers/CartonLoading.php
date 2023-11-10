<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartonLoadingModel;
use App\Models\CartonBarcodeModel;
use App\Models\GlModel;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class CartonLoading extends BaseController
{
    protected $CartonLoadingModel;
    protected $CartonBarcodeModel;
    protected $GlModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->CartonLoadingModel = new CartonLoadingModel();
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->GlModel = new GlModel();
    }

    public function index()
    {
        $gls = $this->GlModel->findAll();
        $data = [
            'title' => 'Carton List to loading',
            'gls' => $gls,
        ];
        return view('cartonloading/index', $data);
    }

    public function index_dt() 
    {
        $carton_list = $this->CartonLoadingModel->getDatatable();
        return DataTable::of($carton_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){

                if($row->flag_loaded == 'Y') {
                    $action_button = '
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Already Received">
                            <a class="btn btn-primary btn-sm mb-1 disabled" style="pointer-events: none;" type="button" disabled>Loaded</a>
                        </span>
                    ';
                } else {
                    $action_button = '
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-1" onclick="load_carton('. $row->id .', this)">Load</a>
                    ';
                }

                $action_button.= ' <a class="btn btn-info btn-sm mb-1 mr-2" onclick="detail_carton('. $row->id .')">Detail</a>';
                return $action_button;

            })->add('content', function($row){

                $size_list_in_carton = $this->CartonBarcodeModel->getCartonContent($row->id);
                $carton_content = $this->CartonBarcodeModel->serialize_size_list($size_list_in_carton);
                return $carton_content;

            })->add('total_pcs', function($row){

                $size_list_in_carton = $this->CartonBarcodeModel->getCartonContent($row->id);
                $total_pcs = array_sum(array_column($size_list_in_carton,'qty'));
                return $total_pcs;

            })->filter(function ($builder, $request) {
                
                if ($request->filter_gl_number)
                    $builder->like('gl_number', $request->filter_gl_number);

            })->postQuery(function ($carton_list) {
                $carton_list->orderBy('tblcartonbarcode.created_at', 'ASC');
            })->toJson(true);
    }

    public function load_carton()
    {
        $carton_id = $this->request->getGet('id');
        $date_update = [
            'flag_loaded' => 'Y',
            'loaded_at' => date('Y-m-d H:i:s'),
        ];
        $this->CartonBarcodeModel->update($carton_id, $date_update);
        $carton = $this->CartonBarcodeModel->find($carton_id);

        $data_return = [
            'status' => 'success',
            'message' => 'Successfully load carton',
            'data' => $carton,
        ];
        return $this->response->setJSON($data_return);
    }

}
