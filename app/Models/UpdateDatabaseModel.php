<?php

namespace App\Models;

use CodeIgniter\Model;

class UpdateDatabaseModel extends Model
{
    protected $DBGroup          = 'default';

    public function get_po_by_gl($gl_number)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where(['gl.gl_number' => $gl_number]);
        $builder->select('po.id as po_id, buyer.buyer_name, gl.gl_number,gl.season');
        $result = $builder->get()->getResult();
        return $result;

    }

    public function get_product_by_po($po_id)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.order_id = po.id');
        $builder->join('tblproduct as product', 'product.id = po_detail.product_id');
        $builder->where(['po.id' => $po_id]);
        $builder->select('po.id as po_id, product.id as product_id, product.product_code');
        $result = $builder->get()->getResult();
        return $result;
    }

    public function update_product_code($product_id, $product_code)
    {
        $builder = $this->db->table('tblproduct');
        $builder->where('id', $product_id);
        $builder->update(['product_code'=> $product_code]);
        return $builder->get()->getRow();
    }
}
