<?php

namespace App\Models;

use CodeIgniter\Model;

class FactoryModel extends Model
{
    protected $table            = 'tblfactory';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'name',
        'incharge',
        'remarks',
    ];

    public function getFactory($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblfactory')->get();
        }
        return $this->where(['code' => $code])->first();
    }

    public function saveFactory($data)
    {
        $query = $this->db->table('tblfactory')->insert($data);
        return $query;
    }

    public function updateFactory($data, $id)
    {
        $query = $this->db->table('tblfactory')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteFactory($id)
    {
        $query = $this->db->table('tblfactory')->delete(array('id' => $id));
        return $query;
    }
}
