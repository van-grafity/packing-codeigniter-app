<?php

namespace App\Models;

use CodeIgniter\Model;

class GLModel extends Model
{
    protected $table = 'tblgl';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'gl_number',
        'season',
        'size_order',
        'buyer_id',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

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
