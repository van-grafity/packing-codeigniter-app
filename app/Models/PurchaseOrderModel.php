<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $table = 'tblpurchaseorder';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = [
        'id',
        'po_no',
        'gl_id',
        'shipdate',
        'PO_qty',
        'PO_amount',
    ];

    public function getPO($id = null)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->select('po.*, buyer.buyer_name, gl.gl_number,gl.season');
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');

        if ($id) {
            $builder->where(['po.id' => $id]);
        }
        $builder->orderBy('po.created_at','DESC');
        $result = $builder->get();
        return $result;
    }

    public function getPurchaseOrder($id = null)
    {
        $GlModel = model('GlModel');

        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->select('po.*');
        $builder->orderBy('po.created_at','DESC');
        $builder->where('po.deleted_at', null);
        
        if ($id) {
            $builder->where(['po.id' => $id]);
            $purchase_order = $builder->get()->getRow();
            $purchase_order = $GlModel->set_gl_info_on_po($purchase_order,$purchase_order->id);
            return $purchase_order;
        }
        
        $purchase_order_list = $builder->get()->getResult();
        foreach ($purchase_order_list as $key => $po) {
            $po = $GlModel->set_gl_info_on_po($po, $po->id);
        }
        
        return $purchase_order_list;
    }

    public function getDatatable()
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->join('tblsyncpurchaseorder as sync_po', 'sync_po.purchase_order_id = po.id');
        $builder->where('po.deleted_at', null);
        $builder->where('sync_po.deleted_at', null);
        $builder->select('po.id, po.po_no, sync_po.buyer_name, sync_po.gl_number, po.shipdate, po.po_qty');
        return $builder;
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

    public function getOrCreateDataByName(Array $data_po)
    {
        $PurchaseOrderModel = model('PurchaseOrderModel');
        
        $data_to_insert = [
            'po_no' => $data_po['po_no'],
            'shipdate' => $data_po['shipdate'],
        ];
        $get_po = $PurchaseOrderModel->where('po_no', $data_po['po_no'])->first();
        if(!$get_po){
            $po_id = $PurchaseOrderModel->insert($data_to_insert);
            $data_gl_po = [
                'gl_id' => $data_po['gl_id'],
                'po_id' => $po_id,
            ];
            $builder = $this->db->table('tblgl_po');
            $builder->insert($data_gl_po);
        } else {
            $po_id = $get_po['id'];
        }
        return $po_id;
    }

    public function is_used_on_packinglist($po_id)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->join('tblpackinglist as pl', 'pl.packinglist_po_id = po.id');
        $builder->where('po.id', $po_id);
        $builder->where('pl.deleted_at', null);
        $result = $builder->get()->getRow();
        
        return $result ? true : false;
    }
}
