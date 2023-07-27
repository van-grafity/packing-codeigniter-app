<?php

namespace App\Models;

use CodeIgniter\Model;

class GlModel extends Model
{
    protected $table = 'tblgl';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'gl_number',
        'season',
        'buyer_id',
        'size_order',
    ];

    public function getGL($gl_id = false)
    {
        $builder = $this->db->table('tblgl');
        $builder->select('tblgl.*, tblbuyer.buyer_name');
        $builder->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id');
        if ($gl_id) {
            $builder->where(['id' => $gl_id])->get();
        }
        return $builder->get();
    }
}
