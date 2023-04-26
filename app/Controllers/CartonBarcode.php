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

    // public function getCartonRatio()
    // {
    //     $builder = $this->db->table('tblcartonratio');
    //     $builder->select('*');
    //     $builder->join('tblcartonbarcode', 'tblcartonbarcode.id = cartonbarcode_id', 'left');
    //     $builder->join('tblpackinglist', 'tblpackinglist.id = tblcartonbarcode.carton_pl_id', 'left');
    //     $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id', 'left');
    //     $builder->join('tblsizes', 'tblsizes.id = size_id', 'left');
    //     return $builder->get();
    // }

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
