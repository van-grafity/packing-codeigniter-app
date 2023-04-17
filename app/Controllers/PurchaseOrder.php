<?php

namespace App\Controllers;

use App\Models\POModel;
use App\Models\GLModel;
helper('number');

class PurchaseOrder extends BaseController
{
    protected $POModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->POModel = new POModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->POModel->select('tblpo.*, tblgl.gl_number, tblgl.season, tblgl.size_order, tblbuyer.buyer_name')
                ->join('tblgl', 'tblgl.id = tblpo.gl_id')
                ->join('tblbuyer', 'tblbuyer.buyer_id = tblgl.buyer_id')
                ->findAll(),
            'validation' => \Config\Services::validation()

        ];

        return view('purchaseorder/index', $data);
    }
}
