<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeModel extends Model
{
    protected $table            = 'tblsize';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'size'
    ];
    protected $returnType = 'object';

    public function getSize($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblsize')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateSize($data, $id)
    {
        $query = $this->db->table('tblsize')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteSize($id)
    {
        $query = $this->db->table('tblsize')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $SizeModel = model('SizeModel');
        $size = $data_to_insert['size'];
        $get_size = $SizeModel->where('size', $size)->first();
        
        if(!$get_size){
            $size_id = $SizeModel->insert(['size'=> $size]);
        } else {
            $size_id = $get_size->id;
        }
        return $size_id;
    }
}
