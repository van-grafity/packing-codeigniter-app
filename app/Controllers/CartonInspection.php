<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CartonInspectionModel;

class CartonInspection extends BaseController
{
    protected $CartonInspectionModel;
    protected $session;

    public function __construct()
    {
        $this->CartonInspectionModel = new CartonInspectionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Carton Inspection',
            'carton_inspection' => $this->CartonInspectionModel->findAll(),
        ];
        
        return view('cartoninspection/index', $data);
    }

    
}
