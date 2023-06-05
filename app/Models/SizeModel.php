<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeModel extends Model
{
    protected $table            = 'tblsizes';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'size'
    ];
    protected $returnType = 'object';

    public function getSize($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblsizes')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateSize($data, $id)
    {
        $query = $this->db->table('tblsizes')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteSize($id)
    {
        $query = $this->db->table('tblsizes')->delete(array('id' => $id));
        return $query;
    }
}
