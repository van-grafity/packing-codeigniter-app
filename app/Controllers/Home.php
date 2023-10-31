<?php

namespace App\Controllers;

use Config\Services;
use App\Models\BuyerModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected $BuyerModel;
    protected $ProductModel;
    protected $helpers = ['number'];
    protected $session;

    public function __construct()
    {
        $this->BuyerModel = new BuyerModel();
        $this->ProductModel = new ProductModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title' => 'Packing App',
            'msg1'  => 'An Application for Shipping Department',
            'msg2'  => '',
            'msg3'  => 'PT. Ghim Li Indonesia',
            'buyer' => $this->BuyerModel->getBuyer()->getResult(),
            'product' => $this->ProductModel->getProduct()->getResult()
        ];

        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('app-layout/dashboard', $data);
    }
}
