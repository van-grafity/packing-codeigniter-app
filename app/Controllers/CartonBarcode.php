<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;

class CartonBarcode extends BaseController
{
    protected $CartonBarcodeModel;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Carton Barcode Setup',
            'carton' => $this->CartonBarcodeModel->getCartonBarcode()->getResult()
        ];

        return view('carton/index', $data);
    }
}
