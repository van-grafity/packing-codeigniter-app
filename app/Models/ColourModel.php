<?php

namespace App\Models;

use CodeIgniter\Model;

class ColourModel extends Model
{

    protected $table         = 'tblcolours';
    protected $useTimestamps = false;
    protected $allowedFields = ['colour_name'];

    public function getColour($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblColour')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateColour($data, $id)
    {
        $query = $this->db->table('tblcolour')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteColour($id)
    {
        $query = $this->db->table('tblcolour')->delete(array('id' => $id));
        return $query;
    }
}
