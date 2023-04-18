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
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.buyer_id = tblgl.buyer_id')
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/index', $data);
    }

    public function detail($packinglist_no)
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*')
                
                ->where('packinglist_no', $packinglist_no)
                ->first(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/detail', $data);
    }
}
