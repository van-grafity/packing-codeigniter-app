<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpurchaseorder';
    protected $allowedFields = [
        'id',
        'po_no',
        'gl_id',
        'shipdate',
        'PO_qty',
        'PO_amount',
        // 'PO_product_id',
    ];

    public function getPO($id = null)
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('tblpurchaseorder.*, tblbuyer.buyer_name, tblgl.gl_number,tblgl.season');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');

        if ($id) {
            $builder->where(['tblpurchaseorder.id' => $id]);
        }
        $builder->orderBy('tblpurchaseorder.created_at','DESC');
        $result = $builder->get();
        return $result;
    }

    public function getPODetails($po_id = null)
    {
        $builder = $this->db->table('tblpurchaseorderdetail');
        $builder->select('tblpurchaseorderdetail.*, tblproduct.product_name, tblproduct.product_price, tblproduct.product_code, tblsize.id as size_id, tblsize.size, tblpurchaseorder.po_qty,tblpurchaseorder.po_amount, tblstyle.style_no, (tblproduct.product_price * tblpurchaseorderdetail.qty ) as total_amount, tblcategory.category_name');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpurchaseorderdetail.order_id');
        $builder->join('tblproduct', 'tblproduct.id = tblpurchaseorderdetail.product_id');
        $builder->join('tblsize', 'tblsize.id = tblproduct.product_size_id');
        $builder->join('tblstyle', 'tblstyle.id = tblproduct.product_style_id');
        $builder->join('tblcategory', 'tblcategory.id = tblproduct.product_category_id');

        if ($po_id) {
            $builder->where(['tblpurchaseorder.id' => $po_id]);
        }

        $result = $builder->get()->getResult();
        return $result;
    }

    public function updatePO($data, $id)
    {
        $query = $this->db->table('tblpurchaseorder')->update($data, array('id' => $id));
        return $query;
    }

    public function syncPurchaseOrderDetails($po_id)
    {

        // ## Get PO details
        $builder = $this->db->table('tblpurchaseorderdetail as pod');
        $builder->select('pod.qty as order_qty, product.product_name, product.product_price, (product.product_price * pod.qty) as amount_per_detail');
        $builder->join('tblpurchaseorder as po', 'po.id = pod.order_id');
        $builder->join('tblproduct as product', 'product.id = pod.product_id');
        $builder->where('po.id', $po_id);
        $po_details = $builder->get()->getResult();

        // ## Calculate
        $po_qty = array_sum(array_map(fn ($detail) => $detail->order_qty, $po_details));
        $po_amount = array_sum(array_map(fn ($detail) => $detail->amount_per_detail, $po_details));

        $data_update = [
            'po_qty' => $po_qty,
            'po_amount' => $po_amount,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $builder_po = $this->db->table('tblpurchaseorder');
        $builder_po->where('id', $po_id);
        $builder_po->update($data_update);

        $result = $builder_po->where('id', $po_id)->get()->getRow();
        return $result;
    }
}
