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
            return $this->db->table('tblColour')->get();
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

    public function getOrCreateColourByName(String $colour_name)
    {
        $get_colour = $colourModel->where('colour_name', $colour_name)->first();
        if(!$get_colour){
            $colour_id = $colourModel->insert(['colour_name'=> $colour_name]);
        } else {
            $colour_id = $get_colour['id'];
        }
        return $colour_id;
    }
}
