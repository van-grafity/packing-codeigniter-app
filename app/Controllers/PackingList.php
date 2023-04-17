<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderDetailModel;
use App\Models\PackingListModel;
use App\Models\GLModel;
use App\Models\BuyerModel;

class PackingList extends BaseController
{
    protected $po, $pod, $pl, $gl, $buyer;

    public function __construct()
    {
        $this->po = new PurchaseOrderModel();
        $this->pl = new PackingListModel();
        $this->gl = new GLModel();
        $this->buyer = new BuyerModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'menu' => 'packinglist',
            'submenu' => 'packinglist',
            'content' => 'pl/index',
        ];
        return view('pl/index', $data);
    }
}
