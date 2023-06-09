<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeModel extends Model
{
    protected $table            = 'tblsize';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'size'
    ];
    protected $returnType = 'object';

    public function getSize($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblsize')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateSize($data, $id)
    {
        $query = $this->db->table('tblsize')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteSize($id)
    {
        $query = $this->db->table('tblsize')->delete(array('id' => $id));
        return $query;
    }
}
