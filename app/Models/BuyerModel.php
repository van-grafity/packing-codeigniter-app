<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyerModel extends Model
{
    protected $table = 'tblBuyer';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'buyer_name',
        'code',
        'offadd',
        'shipadd',
        'country'
    ];

    public function getBuyer($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblbuyer')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateBuyer($data, $id)
    {
        $query = $this->db->table('tblbuyer')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteBuyer($id)
    {
        $query = $this->db->table('tblBuyer')->delete(array('id' => $id));
        return $query;
    }
}
