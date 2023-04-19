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
            'carton' => $this->CartonBarcodeModel->getCartonBarcode()->getResult(),
            'packinglist' => $this->PackingListModel->getPackingList()->getResult(),
            'ratio' => $this->CartonBarcodeModel->getCartonRatio()->getResult()
        ];

        return view('carton/index', $data);
    }
}
