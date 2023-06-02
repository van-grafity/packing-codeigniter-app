<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpackinglist';
    protected $allowedFields = [
        'packinglist_number',
        'packinglist_serial_number',
        'packinglist_date',
        'packinglist_po_id',
        'packinglist_qty',
        'packinglist_cutting_qty',
        'packinglist_ship_qty',
        'packinglist_amount',
    ];

    public function getPackingList($id = false)
    {
        $builder = $this->db->table('tblpackinglist');
        $builder->select('tblpackinglist.*, tblpurchaseorder.id as po_id, tblpurchaseorder.PO_No, tblpurchaseorder.shipdate , tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.GL_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        $builder->orderBy('tblpackinglist.id', 'ASC');
        
        if ($id) {
            $builder->where(['tblpackinglist.id' => $id]);
            $result = $builder->get()->getRow();
        } else {
            $result = $builder->get()->getResult();
        }
        return $result;
    }

    public function get_last_pl_by_month($month_filter = null)
    {
        $month_filter = $month_filter ? $month_filter : date('m');

        $builder = $this->db->table('tblpackinglist as pl');
        $builder->select('pl.*');
        $builder->where("MONTH(pl.created_at)", $month_filter);
        $builder->orderBy('pl.packinglist_number', 'DESC');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getSizeList($packinglist_id)
    {
        //## get all size from this packing list
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->select('size.id, size.size');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.packinglist_id = packinglist.id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblsizes as size', 'size.id = product.product_size_id');
        $builder->where('packinglist.id', $packinglist_id);
        $builder->groupBy('size.id');
        $result = $builder->get()->getResult();
        return $result;
    }

}
