<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpurchaseorder';
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

    public function getPO()
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('*');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id');
        return $builder->get();
    }

    public function getBuyer()
    {
        $builder = $this->db->table('tblbuyer');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblpurchaseorder')->insert($data);
        return $query;
    }
}
