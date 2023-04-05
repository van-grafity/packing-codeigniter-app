<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $useTimestamps = true;

    public function getCategory()
    {
        $builder = $this->db->table('tblcategory');
        return $builder->get();
    }

    public function getProduct()
    {
        $builder = $this->db->table('tblproduct');
        $builder->select('*');
        $builder->join('tblcategory', 'category_id = product_category_id', 'left');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblproduct')->insert($data);
        return $query;
    }

    public function updateProduct($data, $id)
    {
        $query = $this->db->table('tblproduct')->update($data, array('product_id' => $id));
        return $query;
    }

    public function deleteProduct($id)
    {
        $query = $this->db->table('tblproduct')->delete(array('product_id' => $id));
        return $query;
    }
}
