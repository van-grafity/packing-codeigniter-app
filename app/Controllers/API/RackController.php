<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RackModel;
use App\Controllers\API\PalletTransferController;

use CodeIgniter\I18n\Time;

class RackController extends ResourceController
{
    use ResponseTrait;

    protected $RackModel;

    public function __construct()
    {
        $this->RackModel = new RackModel();
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
        $serial_number = $this->request->getGet('serial_number') ? $this->request->getGet('serial_number') : null;
        
        $racks = $this->RackModel
            ->when($serial_number, static function ($query, $serial_number) {
                $query->like('serial_number', '%'.$serial_number.'%');
            })
            ->paginate($params['length'],'default',$params['page']);     

        $data_return = [
            'status' => 'success',
            'message' => 'Successfully get rack',
            'data' => [
                'racks' => $racks,
            ],
        ];
        return $this->respond($data_return);
    }

}
