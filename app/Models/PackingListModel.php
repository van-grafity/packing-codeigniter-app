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
        'destination',
        'department',
        'flag_generate_carton',
    ];

    public function getPackingList($id = false)
    {
        $builder = $this->db->table('tblpackinglist');
        $builder->select('tblpackinglist.*, tblpurchaseorder.id as po_id, tblpurchaseorder.po_no, tblpurchaseorder.shipdate , tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order, tblgl.id as gl_id');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
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

    public function getLastPackinglistByMonth($month_filter = null)
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
        $builder->join('tblsize as size', 'size.id = product.product_size_id');
        $builder->where('packinglist.id', $packinglist_id);
        $builder->groupBy('size.id');
        $builder->orderBy('size.id');
        $result = $builder->get()->getResult();
        return $result;
    }

    public function syncWithPackinglistCarton($packinglist_id = null)
    {
        if (!$packinglist_id) {
            return [
                'status' => false,
                'message' => "Please provide a packinglist ID.",
            ];
        };

        $data_update = [
            'packinglist_cutting_qty' => $this->getShipQty($packinglist_id),
            'packinglist_ship_qty' => $this->getShipQty($packinglist_id),
            'packinglist_amount' => $this->getPackinglistAmount($packinglist_id),
        ];

        $builder = $this->db->table('tblpackinglist');
        $builder->where('id', $packinglist_id);
        $builder->update($data_update);

        $result = $builder->where('id', $packinglist_id)->get()->getRow();
        return $result;
    }

    public function getTotalCarton($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglistcarton');
        $builder->selectSum('carton_qty');
        $builder->where('packinglist_id', $packinglist_id);
        $result = $builder->get()->getRow();
        return $result->carton_qty ? $result->carton_qty : 0;
    }

    public function getShipQty($packinglist_id = null)
    {
        $builder = $this->db->table('tblcartondetail as carton_detail');
        $builder->select('sum(carton_detail.product_qty * pl_carton.carton_qty) as ship_qty');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_detail.packinglist_carton_id');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $result = $builder->get()->getRow();
        return $result->ship_qty;
    }

    public function getShipmentPercentage($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->where('packinglist.id', $packinglist_id);
        $order_qty = $builder->get()->getRow()->packinglist_qty;
        $ship_qty = $this->getShipQty($packinglist_id);
        $percentage_ship = round($ship_qty / $order_qty * 100) . '%';
        return $percentage_ship;
    }

    public function getPackinglistAmount($packinglist_id = null)
    {
        $builder = $this->db->table('tblcartondetail as carton_detail');
        $builder->select('sum(carton_detail.product_qty * pl_carton.carton_qty * product.product_price) as packinglist_amount');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_detail.packinglist_carton_id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $result = $builder->get()->getRow();
        return $result->packinglist_amount;
    }
}
