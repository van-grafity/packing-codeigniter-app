<?php

namespace App\Models;

use CodeIgniter\Model;

class GLModel extends Model
{
    protected $table = 'tblgl';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'gl_number',
        'season',
        'style_id',
        'buyer_id',
        'size_order',
    ];

    public function getGL($code = false)
    {
        if ($code == false) {
            $builder = $this->db->table('tblgl');
            $builder->select('tblgl.*, tblbuyer.buyer_name, tblstyle.style_description');
            $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id', 'left');
            $builder->join('tblstyle', 'tblstyle.id = tblgl.style_id', 'left');
            return $builder->get();
        }
        $builder = $this->db->table('tblgl');
        $builder->select('tblgl.*, tblbuyer.buyer_name, tblstyle.style_description');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id', 'left');
        $builder->join('tblstyle', 'tblstyle.id = tblgl.style_id', 'left');
        return $builder->where(['id' => $code])->get();
    }

    public function updateGL($data, $id)
    {
        $query = $this->db->table('tblgl')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteGL($id)
    {
        $query = $this->db->table('tblgl')->delete(array('id' => $id));
        return $query;
    }
}
