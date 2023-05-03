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
        $builder->select('*');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id');
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
