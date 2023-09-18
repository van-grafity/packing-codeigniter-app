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
        $builder = $this->db->table('tblpallet');
        $builder->select('id, serial_number, description, flag_empty');
        return $builder;
    }

    public function updatePallet($data, $id)
    {
        $query = $this->db->table('tblpallet')->update($data, array('id' => $id));
        return $query;
    }

    public function deletePallet($id)
    {
        $query = $this->db->table('tblpallet')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $PalletModel = model('PalletModel');
        $pallet_name = $data_to_insert['pallet'];
        $get_pallet = $PalletModel->where('pallet_name', $pallet_name)->first();
        if(!$get_pallet){
            $pallet_id = $PalletModel->insert(['pallet_name'=> $pallet_name]);
        } else {
            $pallet_id = $get_pallet['id'];
        }
        return $pallet_id;
    }

    public function getIdByName(String $name)
    {
        $PalletModel = model('PalletModel');
        $pallet_id = $PalletModel->where('pallet_name',$name)->first()['id'];
        return $pallet_id;
    }
}
