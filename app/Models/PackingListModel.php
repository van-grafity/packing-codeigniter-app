<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListModel extends Model
{
    protected $table = 'tblpackinglist';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
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
        $GlModel = model('GlModel');

        $builder = $this->db->table('tblpackinglist as pl');
        $builder->select('pl.*, po.id as po_id, po.po_no, po.po_qty, po.shipdate');
        $builder->join('tblpurchaseorder as po', 'po.id = pl.packinglist_po_id');
        $builder->orderBy('pl.id', 'ASC');
        $builder->where(['pl.deleted_at' => null]);

        if ($id) {
            $builder->where(['pl.id' => $id]);
            $result = $builder->get()->getRow();
            $result = $GlModel->set_gl_info_on_po($result, $result->po_id);
        } else {
            $result = $builder->get()->getResult();
            foreach ($result as $key => $po) {
                $po = $GlModel->set_gl_info_on_po($po, $po->po_id);
            }
        }
        return $result;
    }

    public function getDatatable()
    {
        $builder = $this->db->table('tblpackinglist as pl');
        $builder->join('tblpurchaseorder as po', 'po.id = pl.packinglist_po_id');
        $builder->join('tblsyncpurchaseorder as sync_po', 'sync_po.purchase_order_id = po.id');
        $builder->where('pl.deleted_at', null);
        $builder->select('pl.id as packinglist_id, po.id as po_id, po.po_no, sync_po.buyer_name, sync_po.gl_number, sync_po.season, po.shipdate, po.po_qty, pl.packinglist_serial_number');
        return $builder;
    }

    public function getLastPackinglistByMonth($year_filter = null, $month_filter = null)
    {
        $month_filter = $month_filter ? $month_filter : date('m');
        $year_filter = $year_filter ? $year_filter : date('m');

        $builder = $this->db->table('tblpackinglist as pl');
        $builder->select('pl.*');
        $builder->where("MONTH(pl.created_at)", $month_filter);
        $builder->where("YEAR(pl.created_at)", $year_filter);
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
        $builder->where('carton_detail.deleted_at', null);
        $builder->groupBy('size.id');
        $builder->orderBy('size.size_order');
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
        $builder->where('tblpackinglistcarton.deleted_at', null);
        $result = $builder->get()->getRow();
        return $result->carton_qty ? $result->carton_qty : 0;
    }

    public function getShipQty($packinglist_id = null)
    {
        $builder = $this->db->table('tblcartondetail as carton_detail');
        $builder->select('sum(carton_detail.product_qty * pl_carton.carton_qty) as ship_qty');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_detail.packinglist_carton_id');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $builder->where('carton_detail.deleted_at', null);
        $builder->where('pl_carton.deleted_at', null);
        $result = $builder->get()->getRow();
        return $result->ship_qty;
    }

    public function getShipmentPercentage($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->where('packinglist.id', $packinglist_id);
        $order_qty = $builder->get()->getRow()->packinglist_qty;
        $ship_qty = $this->getShipQty($packinglist_id);
        $percentage_ship = round($ship_qty / $order_qty * 100, 4) . '%';
        return $percentage_ship;
    }

    public function getPackinglistAmount($packinglist_id = null)
    {
        $builder = $this->db->table('tblcartondetail as carton_detail');
        $builder->select('sum(carton_detail.product_qty * pl_carton.carton_qty * product.product_price) as packinglist_amount');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_detail.packinglist_carton_id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $builder->where('carton_detail.deleted_at', null);
        $builder->where('pl_carton.deleted_at', null);
        $result = $builder->get()->getRow();
        return $result->packinglist_amount;
    }

    public function getContractQty($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->select('sum(po_detail.qty) as qty, size.size');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.order_id = po.id');
        $builder->join('tblproduct as product', 'product.id = po_detail.product_id');
        $builder->join('tblsize as size','size.id = product.product_size_id');
        $builder->where('packinglist.id', $packinglist_id);
        $builder->orderBy('size.size_order');
        $builder->groupBy('size.id');
        $result = $builder->get()->getResult();

        $contract_qty_per_size = array();
        foreach ($result as $key => $value) {
            $contract_qty_per_size[] = $value->size . ' = ' . $value->qty;
        }

        $contract_qty_all_size = join(' | ', $contract_qty_per_size);

        return $contract_qty_all_size;
    }

    public function getShipmentPercentageEachProduct($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->select('product.id as product_id, product.product_code as upc, colour.colour_name as colour, size.size, sum((pl_carton.carton_qty*carton_detail.product_qty)) as shipment_qty');
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.packinglist_id = packinglist.id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product','product.id = carton_detail.product_id');
        $builder->join('tblcolour as colour','colour.id = product.product_colour_id');
        $builder->join('tblsize as size','size.id = product.product_size_id');
        $builder->where('packinglist.id', $packinglist_id);
        $builder->where('carton_detail.deleted_at', null);
        $builder->groupBy('product.id');
        $result = $builder->get()->getResult();
        
        return $result;
    }

    public function getContractQtyEachProduct($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->select('product.id as product_id, product.product_code as upc, po_detail.qty as po_qty');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.order_id = po.id');
        $builder->join('tblproduct as product', 'product.id = po_detail.product_id');
        $builder->where('packinglist.id', $packinglist_id);
        $builder->where('po_detail.deleted_at', null);
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getBuyerByPackinglistId($packinglist_id = null)
    {
        if ($packinglist_id == null) {
            return null;
        }

        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->select('buyer.id as buyer_id,buyer.buyer_name as buyer_name');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where('packinglist.id', $packinglist_id);
        $result = $builder->get()->getRow();
        return $result;
    }

    public function isRelatedToCartonBarcode($packinglist_id) : bool
    {
        $builder = $this->db->table('tblpackinglist as packinglist');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.packinglist_id = packinglist.id');
        $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.packinglist_carton_id = pl_carton.id');
        $builder->where('packinglist.id',$packinglist_id);
        $result = $builder->get()->getResult();

        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
