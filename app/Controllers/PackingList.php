<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\PackingListSizeModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;

class PackingList extends BaseController
{
    protected $pl;
    protected $buyerModel;
    protected $plsize;

    public function __construct()
    {
        $this->pl = new PackingListModel();
        $this->buyerModel = new BuyerModel();
        $this->plsize = new PackingListSizeModel();
        $this->po = new PurchaseOrderModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->findAll(),
            'buyer'  => $this->buyerModel->getBuyer()->getResult(),
            'po' => $this->po->select('tblpurchaseorder.*')->get()->getResult(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/index', $data);
    }

    public function detail($packinglist_no)
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->where('tblpackinglist.packinglist_no', $packinglist_no)
                ->first(),
            'plsizes' => $this->plsize->select('tblpackinglistsizes.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.packinglistsize_size_id')
                ->where('tblpackinglistsizes.packinglistsize_pl_id', $this->pl->select('tblpackinglist.id')
                    ->where('tblpackinglist.packinglist_no', $packinglist_no)
                    ->first()['id'])
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/detail', $data);
    }

    // store
    public function store() {
        // dd($this->request->getVar());
        // validation
        if (!$this->validate([
            'packinglist_no' => [
                'rules' => 'required|is_unique[tblpackinglist.packinglist_no]',
                'errors' => [
                    'required' => 'Packing List No is required',
                    'is_unique' => 'Packing List No already registered'
                ]
            ],
            'packinglist_po_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'PO No is required'
                ]
            ],
            'packing_list_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Date is required'
                ]
            ],
            'packing_list_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Qty is required'
                ]
            ],
            'packing_list_cutting_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Cutting Qty is required'
                ]
            ],
            'packing_list_ship_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Ship Qty is required'
                ]
            ],
            'packing_list_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Amount is required'
                ]
            ],
            'packing_list_created_at' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Created At is required'
                ]
            ],
            'packing_list_updated_at' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Packing List Updated At is required'
                ]
            ]
        ])) {
            return redirect()->to('/packinglist')->withInput();
        }

        $this->pl->save([
            'packinglist_no' => $this->request->getVar('packinglist_no'),
            'packinglist_po_id' => $this->request->getVar('packinglist_po_id'),
            'packing_list_date' => $this->request->getVar('packing_list_date'),
            'packing_list_qty' => $this->request->getVar('packing_list_qty'),
            'packing_list_cutting_qty' => $this->request->getVar('packing_list_cutting_qty'),
            'packing_list_ship_qty' => $this->request->getVar('packing_list_ship_qty'),
            'packing_list_amount' => $this->request->getVar('packing_list_amount'),
            'packing_list_created_at' => $this->request->getVar('packing_list_created_at'),
            'packing_list_updated_at' => $this->request->getVar('packing_list_updated_at')
        ]);

        session()->setFlashdata('message', 'Added Successfully !');
        return redirect()->to('/packinglist');
    }
}