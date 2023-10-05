<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletModel extends Model
{

    protected $table         = 'tblpallet';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['serial_number','description','flag_empty'];

    public function getPallet($pallet_id = null)
    {
        if ($pallet_id) {
            return $this->where(['id' => $pallet_id])->first();
        }
        return $this->db->table('tblpallet')->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this->db->table('tblpallet as pallet');
        $builder->select('id, serial_number, description, flag_empty');
        return $builder;
    }
}
