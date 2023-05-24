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
    protected $PLModel;
    protected $BuyerModel;
    protected $PurchaseOrderModel;
    protected $SizeModel;

    public function __construct()
    {
        $this->PLModel = new PackingListModel();
        $this->BuyerModel = new BuyerModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->SizeModel = new SizeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',

        ];
        return view('pl/index', $data);
    }
}
