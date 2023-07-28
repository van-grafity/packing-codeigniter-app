<?php

namespace App\Models;

use CodeIgniter\Model;

class ColourModel extends Model
{

    protected $table         = 'tblcolour';
    protected $useTimestamps = true;
    protected $allowedFields = ['colour_name'];

    public function getColour($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblcolour')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateColour($data, $id)
    {
        $query = $this->db->table('tblcolour')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteColour($id)
    {
        $query = $this->db->table('tblcolour')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $ColourModel = model('ColourModel');
        $colour_name = $data_to_insert['colour'];
        $get_colour = $ColourModel->where('colour_name', $colour_name)->first();
        if(!$get_colour){
            $colour_id = $ColourModel->insert(['colour_name'=> $colour_name]);
        } else {
            $colour_id = $get_colour['id'];
        }
        return $colour_id;
    }

    public function getIdByName(String $name)
    {
        $ColourModel = model('ColourModel');
        $colour_id = $ColourModel->where('colour_name',$name)->first()['id'];
        return $colour_id;
    }
}
