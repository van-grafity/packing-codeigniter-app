<?php

namespace App\Controllers;

use App\Models\POModel, App\Models\BuyerModel, App\Models\ProductModel;

helper('number');

class PO extends BaseController
{
    protected $POModel, $ProductModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->POModel = new POModel();
        $this->ProductModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Buyer Purchase Order',
            'buyerPO'   => $this->POModel->getPO()->getResult(),
            'buyer'     => $this->POModel->getBuyer()->getResult(),
            'product'   => $this->ProductModel->getProduct()->getResult()
        ];

        return view('order/index', $data);
    }
}
