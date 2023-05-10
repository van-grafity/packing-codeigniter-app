<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpackinglist';
    protected $allowedFields = [
        'packinglist_no',
        'packinglist_date',
        'packinglist_po_id',
        'packinglist_qty',
        'packinglist_cutting_qty',
        'packinglist_ship_qty',
        'packinglist_amount',
    ];

    public function getPackingList()
    {
        $builder = $this->db->table('tblpackinglist');
        $builder->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        return $builder->get();
    }

    public function getPackingListSize()
    {
        $builder = $this->db->table('tblpackinglistsizes');
        $builder->select('tblpackinglistsizes.*, tblsizes.size');
        $builder->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.id');
        return $builder->get();
    }

    public function getPackingListByNo($packinglist_no)
    {
        $builder = $this->db->table('tblpackinglist');
        $builder->select('tblpackinglist.*, tblpurchaseorder.PO_No,tblpurchaseorder.shipdate, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order, tblstyles.style_description');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        $builder->join('tblpurchaseorderstyle', 'tblpurchaseorderstyle.purchase_order_id = tblpurchaseorder.id');
        $builder->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id');
        $builder->where('tblpackinglist.packinglist_no', $packinglist_no);
        return $builder->get();
    }
    
    public function getPackingListSizeByNo($packinglist_no)
    {
        $builder = $this->db->table('tblpackinglistsizes');
        $builder->select('tblpackinglistsizes.*, tblsizes.size, tblstyles.style_description');
        $builder->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.packinglistsize_size_id');
        $builder->join('tblstyles', 'tblstyles.id = tblpackinglistsizes.packinglistsize_style_id');
        $builder->join('tblpackinglist', 'tblpackinglist.id = tblpackinglistsizes.packinglistsize_pl_id');
        $builder->where('tblpackinglist.packinglist_no', $packinglist_no);
        return $builder->get();
    }

    public function getPO()
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('*');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id');
        return $builder->get();
    }

    public function savePackingList($data)
    {
        $query = $this->db->table('tblpackinglist')->insert($data);
        return $query;
    }

    public function getSizeByPoId($po_id) {
        $builder = $this->db->table('tblpurchaseorderstyle');
        $builder->select('*');
        $builder->join('tblstyles', 'tblstyles.id = tblpurchaseorderstyle.style_id');
        $builder->join('tblsizes', 'tblsizes.id = tblpurchaseorderstyle.size_id');
        $builder->where('tblpurchaseorderstyle.purchase_order_id', $po_id);
        return $builder->get();
    }
}
