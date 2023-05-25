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

    public function getPO($code = null)
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('tblpurchaseorder.*, tblbuyer.buyer_name, tblgl.gl_number,tblgl.season');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');

        if($code) {
            $builder->where(['PO_No' => $code]);
        }
        $result = $builder->get();
        return $result;
    }

    public function getPODetails($code = null)
    {
        $builder = $this->db->table('tblpurchaseorderdetail');
        $builder->select('tblpurchaseorderdetail.*, tblproduct.product_name, tblproduct.product_price, tblproduct.product_code,tblsizes.size,tblpurchaseorder.PO_Qty,tblpurchaseorder.PO_Amount, tblstyles.style_no, (tblproduct.product_price * tblpurchaseorderdetail.qty ) as total_amount');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpurchaseorderdetail.order_id');
        $builder->join('tblsizes', 'tblsizes.id = tblpurchaseorderdetail.size_id');
        $builder->join('tblproduct', 'tblproduct.id = tblpurchaseorderdetail.product_id');
        $builder->join('tblstyles', 'tblstyles.id = tblproduct.product_style_id');

        if($code) {
            $builder->where(['PO_No' => $code]);
        }

        $result = $builder->get()->getResult();
        return $result;
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
        if($query) {
            return $this->db->insertID();
        } else {
            return $query;
        }
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
