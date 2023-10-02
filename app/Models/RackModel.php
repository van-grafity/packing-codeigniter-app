<?php

namespace App\Models;

use CodeIgniter\Model;

class RackModel extends Model
{

    protected $table         = 'tblrack';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['serial_number','description','location'];

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
        $builder->select('id, serial_number, description, location');
        return $builder;
    }

    public function updateRack($data, $id)
    {
        $query = $this->db->table('tblrack')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteRack($id)
    {
        $query = $this->db->table('tblrack')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $RackModel = model('RackModel');
        $rack_name = $data_to_insert['rack'];
        $get_rack = $RackModel->where('rack_name', $rack_name)->first();
        if(!$get_rack){
            $rack_id = $RackModel->insert(['rack_name'=> $rack_name]);
        } else {
            $rack_id = $get_rack['id'];
        }
        return $rack_id;
    }

    public function getIdByName(String $name)
    {
        $RackModel = model('RackModel');
        $rack_id = $RackModel->where('rack_name',$name)->first()['id'];
        return $rack_id;
    }
}
