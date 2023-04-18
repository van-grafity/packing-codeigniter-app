<?php

namespace App\Models;

use CodeIgniter\Model;

class GLModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblgl';
    protected $allowedFields = [
        'gl_number',
        'season',
        'size_order',
    ];

    public function getGL()
    {
        $builder = $this->db->table('tblgl');
        $builder->select('*');
        $builder->join('tblbuyer', 'tblbuyer.buyer_id = tblgl.buyer_id');
        return $builder->get();
    }

    public function getBuyer()
    {
        $builder = $this->db->table('tblbuyer');
        return $builder->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblgl')->insert($data);
        return $query;
    }
}
