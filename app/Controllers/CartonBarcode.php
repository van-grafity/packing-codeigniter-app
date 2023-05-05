<?php

namespace App\Controllers;

use App\Models\CartonBarcodeModel;
use App\Models\PackingListModel;

class CartonBarcode extends BaseController
{
    protected $CartonBarcodeModel;
    protected $PackingListModel;

    public function __construct()
    {
        $this->CartonBarcodeModel = new CartonBarcodeModel();
        $this->PackingListModel = new PackingListModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Carton Barcode Setup',
            'packinglist' => $this->PackingListModel->getPackingList()->getResultArray(),
            'carton' => $this->CartonBarcodeModel->getCartonBarcode()->getResultArray(),
            'ratio' => $this->CartonBarcodeModel->getCartonRatio()->getResultArray(),
            'size' => $this->CartonBarcodeModel->getSize()->getResultArray(),
            'validation' => \Config\Services::validation()
        ];

        return view('carton/index', $data);
    }
}
