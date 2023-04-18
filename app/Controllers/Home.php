<?php

namespace App\Controllers;

use App\Models\BuyerModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected $BuyerModel;
    protected $ProductModel;
    protected $helpers = ['number'];

    public function __construct()
    {
        $this->BuyerModel = new BuyerModel();
        $this->ProductModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title' => 'SCAN & PACK SYSTEM',
            'msg1'  => 'An Application for Shipping Department',
            'msg2'  => '',
            'msg3'  => 'PT. Ghim Li Indonesia',
            'buyer' => $this->BuyerModel->getBuyer()->getResult(),
            'product' => $this->ProductModel->getProduct()->getResult()
        ];

        return view('app-layout/dashboard', $data);
    }
}
