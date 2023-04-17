<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $table = 'tblpo';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'PO_No',
        'gl_id',
        'PO_product_id',
        'factory_id',
        'shipdate',
        'unit_price',
        'PO_qty',
        'PO_amount',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPO()
    {
        $builder = $this->db->table('tblPO');
        $builder->select('*');
        $builder->join('tblgl', 'tblgl.id = tblPO.gl_id');
        $builder->join('tblproduct', 'tblproduct.product_id = tblPO.PO_product_id');
        $builder->join('tblfactory', 'tblfactory.id = tblPO.factory_id');
        return $builder->get();
    }

    public function getBuyer()
    {
        $builder = $this->db->table('tblbuyer');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblPO')->insert($data);
        return $query;
    }
}
