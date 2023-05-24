<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpurchaseorder';
    protected $allowedFields = [
        'id',
        'PO_No',
        'gl_id',
        'shipdate',
        'PO_qty',
        'PO_amount',
        // 'PO_product_id',
    ];

    public function getPO()
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('tblpurchaseorder.*, tblbuyer.buyer_name, tblgl.gl_number,tblgl.season');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        return $builder->get();
    }

    public function getPODetails($code = false)
    {
        if ($code == false) {
            $builder = $this->db->table('tblpurchaseorderdetail');
            $builder->select('tblpurchaseorderdetail.*, tblproduct.product_name, tblproduct.product_price,tblsizes.size,tblpurchaseorder.PO_Qty,tblpurchaseorder.PO_Amount');
            $builder->join('tblsizes', 'tblsizes.id = tblpurchaseorderdetail.size_id');
            $builder->join('tblproduct', 'tblproduct.id = tblpurchaseorderdetail.product_id');
            $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpurchaseorderdetail.order_id');
            return $builder->get();
        }
        $builder = $this->db->table('tblpurchaseorderdetail');
        $builder->select('tblpurchaseorderdetail.*, tblproduct.product_name, tblproduct.product_price,tblsizes.size,tblpurchaseorder.PO_Qty,tblpurchaseorder.PO_Amount');
        $builder->join('tblsizes', 'tblsizes.id = tblpurchaseorderdetail.size_id');
        $builder->join('tblproduct', 'tblproduct.id = tblpurchaseorderdetail.product_id');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpurchaseorderdetail.order_id');
        return $builder->where(['code' => $code])->get();
    }

    public function getGL()
    {
        $builder = $this->db->table('tblgl');
        return $builder->get();
    }

    public function getBuyer($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblbuyer')->get();
        }
        return $this->where(['code' => $code])->first();
    }

    public function getPoduct()
    {
        $builder = $this->db->table('tblproduct');
        return $builder->get();
    }

    public function getSize($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblsizes')->get();
        }
        return $this->where(['code' => $code])->first();
    }

    public function savePO($data)
    {
        $query = $this->db->table('tblpurchaseorder')->insert($data);
        return $query;
    }

    public function updatePO($data, $id)
    {
        $query = $this->db->table('tblpurchaseorder')->update($data, array('id' => $id));
        return $query;
    }

    public function deletePO($data)
    {
    }
}
