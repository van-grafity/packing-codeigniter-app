<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'tblcategory';
    protected $useTimestamps = true;
    protected $allowedFields = ['category_name'];

    public function getCategory($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblcategory')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateCategory($data, $id)
    {
        $query = $this->db->table('tblcategory')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteCategory($id)
    {
        $query = $this->db->table('tblcategory')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $CategoryModel = model('CategoryModel');
        $product_type = $data_to_insert['product_type'];
        $get_category = $CategoryModel->where('category_name', $product_type)->first();
        if(!$get_category){
            $category_id = $CategoryModel->insert(['category_name'=> $product_type]);
        } else {
            $category_id = $get_category['id'];
        }
        return $category_id;
    }
}
