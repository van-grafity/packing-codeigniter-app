<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;

class CartonBarcode extends BaseController
{
    protected $CartonBarcodeModel;
    protected $PackingListModel;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Carton Barcode Setup',
            'carton' => $this->CartonBarcodeModel->getCartonBarcode()->getResultArray(),
            'ratio' => $this->CartonBarcodeModel->getCartonRatio()->getResultArray()
        ];

        return view('carton/index', $data);
    }
}
