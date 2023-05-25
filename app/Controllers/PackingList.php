<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;
use App\Models\SizeModel;

helper('number', 'form', 'url', 'text');

class PackingList extends BaseController
{
    protected $PackingListModel;
    protected $BuyerModel;
    protected $PurchaseOrderModel;
    protected $SizeModel;

    public function __construct()
    {
        $this->PackingListModel = new PackingListModel();
        $this->BuyerModel = new BuyerModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->SizeModel = new SizeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'PackingList'   => $this->PackingListModel->getPackingList()->getResult(),

        ];
        // dd($data['PackingList']);
        return view('pl/index', $data);
    }

    public function detail()
    {
        $data = [
            'title'             => 'Packing List Detail',
            'OrderPackingList'  => $this->PackingListModel->getPackingListDetail()->getResult(),
        ];
        return view('PL/detail', $data);
    }
}
