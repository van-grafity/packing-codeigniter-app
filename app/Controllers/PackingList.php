<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\PackingListSizeModel;
use App\Models\BuyerModel;
use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderStyleModel;
use App\Models\StyleModel;

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
        $this->pos = new PurchaseOrderStyleModel();
        $this->style = new StyleModel();
    }

    public function index()
    {
        $packinglist_no = strlen($this->pl->countAllResults()) == 1 ? 'PL-000' . $this->pl->countAllResults() + 1 : 'PL-00' . $this->pl->countAllResults() + 1;
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->findAll(),
            'plsize' => $this->plsize->select('tblpackinglistsizes.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.id')
                ->findAll(),
            'buyer'  => $this->buyerModel->getBuyer()->getResult(),
            'po' => $this->po->select('tblpurchaseorder.*')->get()->getResult(),
            'packinglist_no' => $packinglist_no,
            'validation' => \Config\Services::validation()
        ];
        return view('pl/index', $data);
    }

    public function detail($packinglist_no)
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No,tblpurchaseorder.shipdate, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order, tblstyles.style_description')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->join('tblpurchaseorderstyle', 'tblpurchaseorderstyle.purchase_order_id = tblpurchaseorder.id')
                ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
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

    public function store() {
        // dd($this->request->getVar());
        if (!$this->validate([
            'packinglist_no' => [
                'rules' => 'required|is_unique[tblpackinglist.packinglist_no]',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.',
                    'is_unique' => '{field} packinglist sudah terdaftar.'
                ]
            ],
            'packinglist_po_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_cutting_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_ship_qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ],
            'packinglist_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} packinglist harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/packinglist')->withInput();
        }

        $this->pl->save([
            'packinglist_no' => $this->request->getVar('packinglist_no'),
            'packinglist_po_id' => $this->request->getVar('packinglist_po_id'),
            'packinglist_date' => $this->request->getVar('packinglist_date'),
            'packinglist_qty' => $this->request->getVar('packinglist_qty'),
            'packinglist_cutting_qty' => $this->request->getVar('packinglist_cutting_qty'),
            'packinglist_ship_qty' => $this->request->getVar('packinglist_ship_qty'),
            'packinglist_amount' => $this->request->getVar('packinglist_amount')
        ]);

        $packinglist_id = $this->pl->select('tblpackinglist.id')
            ->where('tblpackinglist.packinglist_no', $this->request->getVar('packinglist_no'))
            ->first()['id'];

        $packinglistsize_size_id = $this->request->getVar('packinglistsize_size_id');
        $packinglistsize_qty = $this->request->getVar('packinglistsize_qty');
        $packinglistsize_amount = $this->request->getVar('packinglistsize_amount');

        for ($i = 0; $i < count($packinglistsize_size_id); $i++) {
            $this->plsize->save([
                'packinglistsize_pl_id' => $packinglist_id,
                'packinglistsize_size_id' => $packinglistsize_size_id[$i],
                'packinglistsize_qty' => $packinglistsize_qty[$i],
                'packinglistsize_amount' => $packinglistsize_amount[$i]
            ]);
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/packinglist');
    }

    public function getSizeByPoId($po_id) {
        $sizes = $this->po->select('tblpurchaseorder.*, tblsizes.size')
            ->join('tblpurchaseorderstyle', 'tblpurchaseorderstyle.purchase_order_id = tblpurchaseorder.id')
            ->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id')
            ->join('tblstylesizes', 'tblstylesizes.style_id = tblstyles.id')
            ->join('tblsizes', 'tblsizes.id = tblstylesizes.size_id')
            ->where('tblpurchaseorder.id', $po_id)
            ->findAll();

        echo json_encode($sizes);
    }
}