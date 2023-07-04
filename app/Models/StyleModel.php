<?php

namespace App\Models;

use CodeIgniter\Model;

class StyleModel extends Model
{
    protected $table = 'tblstyle';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'style_no',
        'style_description',
    ];

    public function getStyle($code = false)
    {
        if ($code == false) {
            return $this->db->table('tblstyle')->get();
        }
        return $this->where(['id' => $code])->first();
    }

    public function updateStyle($data, $id)
    {
        $query = $this->db->table('tblstyle')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteStyle($id)
    {
        $query = $this->db->table('tblstyle')->delete(array('id' => $id));
        return $query;
    }

    public function getOrCreateDataByName(String $style_no, String $style_desc)
    {
        $StyleModel = model('StyleModel');
        $get_style = $StyleModel->where('style_no', $style_no)->first();
        if(!$get_style){
            $style_id = $StyleModel->insert(['style_no'=> $style_no, $style_desc]);
        } else {
            $style_id = $get_style['id'];
        }
        return $style_id;
    }
}
