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

    public function getPackingList($code = false)
    {
        if ($code == false) {
            $builder = $this->db->table('tblpackinglist');
            $builder->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblpurchaseorder.GL_id, tblgl.gl_number, tblgl.season, tblbuyer.buyer_name');
            $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
            $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.GL_id');
            $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
            return $builder->get();
        }
        $builder = $this->db->table('tblpackinglist');
        $builder->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        return $builder->where(['code' => $code])->get();
    }

    public function savePackingList($data)
    {
        $query = $this->db->table('tblpackinglist')->insert($data);
        return $query;
    }
}
