<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LocationModel;
use App\Controllers\API\PalletTransferController;

use CodeIgniter\I18n\Time;

class LocationController extends ResourceController
{
    use ResponseTrait;

    protected $LocationModel;

    public function __construct()
    {
        $this->LocationModel = new LocationModel();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $locations = $this->LocationModel->findAll();       
        $data_return = [
            'status' => 'success',
            'message' => 'Successfully get location',
            'data' => [
                'locations' => $locations,
            ],
        ];
        return $this->respond($data_return);
    }

}
