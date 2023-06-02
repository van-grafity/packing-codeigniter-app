<?php

namespace App\Models;

use CodeIgniter\Model;

class StyleModel extends Model
{
    protected $table = 'tblstyles';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'style_no',
        'style_description',
    ];

    public function getStyles($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblstyles')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateStyle($data, $id)
    {
        $query = $this->db->table('tblstyles')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteStyle($id)
    {
        $query = $this->db->table('tblstyles')->delete(array('id' => $id));
        return $query;
    }
}
