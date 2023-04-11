<?php

namespace App\Models;

use CodeIgniter\Model;

class POModel extends Model
{
    protected $useTimestamps = true;
    protected $allowedFields = [
        'PO_No', 'PO_buyer_id',
        'PO_product_id', 'shipdate',
        'unit_price', 'PO_qty', 'PO_amount'
    ];

    public function getBuyer()
    {
        $builder = $this->db->table('tblbuyer');
        return $builder->get();
    }

    public function getPO()
    {
        $builder = $this->db->table('tblPO');
        $builder->select('*');
        $builder->join('tblbuyer', 'buyer_id = PO_buyer_id', 'left');
        $builder->join('tblProduct', 'product_id = PO_product_id', 'left');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblPO')->insert($data);
        return $query;
    }
}
