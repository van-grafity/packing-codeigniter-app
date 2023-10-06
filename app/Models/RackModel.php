<?php

namespace App\Models;

use CodeIgniter\Model;

class RackModel extends Model
{

    protected $table         = 'tblrack';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['serial_number','description','flag_empty'];

    public function getRack($rack_id = null)
    {
        if ($rack_id) {
            return $this->where(['id' => $rack_id])->first();
        }
        return $this->db->table('tblrack')->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->select('id, serial_number, description, flag_empty');
        return $builder;
    }
}
