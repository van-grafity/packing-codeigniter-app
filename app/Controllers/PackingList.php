<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;

class PackingList extends BaseController
{
    protected $pl;

    public function __construct()
    {
        $this->pl = new PackingListModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->getPackingList()->getResult(),
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/index', $data);
    }
}
