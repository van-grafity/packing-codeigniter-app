<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $useTimestamps = true;
    protected $allowedFields = [
        'product_code',
        'product_asin_id',
        'style',
        'product_name',
        'product_price',
        'product_category_id'
    ];

    public function getCategory()
    {
        $builder = $this->db->table('tblcategory');
        return $builder->get();
    }

    public function getProduct()
    {
        $builder = $this->db->table('tblproduct');
        $builder->select('*');
        $builder->join('tblcategory', 'tblcategory.id = product_category_id', 'left');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblproduct')->insert($data);
        return $query;
    }

    public function updateProduct($data, $id)
    {
        $query = $this->db->table('tblproduct')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteProduct($id)
    {
        $query = $this->db->table('tblproduct')->delete(array('id' => $id));
        return $query;
    }
}
