<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'tblcategory';
    protected $useTimestamps = true;
    protected $allowedFields = ['category_name'];

    public function getCategory($id = false)
    {
        if ($id == false) {
            return $this->db->table('tblcategory')->get();
        }
        return $this->where(['id' => $id])->first();
    }

    public function saveCategory($data)
    {
        $query = $this->db->table('tblcategory')->insert($data);
        return $query;
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
}
