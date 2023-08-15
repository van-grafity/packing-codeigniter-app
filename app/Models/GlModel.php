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
        $builder->orderBy('tblgl.gl_number', 'asc');
        return $builder->get();
    }

    public function insertGL_PO($data_gl_po) : bool
    {
        $builder = $this->db->table('tblgl_po');
        $insert_gl_po = $builder->insert($data_gl_po);
        return $insert_gl_po;
    }

    public function getGlListByPo($po_id = null) : object
    {
        $emptyGl = (object)[
            'gl_number' => '-',
            'buyer_name' => '-',
        ];

        if(!$po_id){
            return $emptyGl;
        }
        $builder = $this->db->table('tblgl as gl');
        $builder->select('gl.gl_number, buyer.buyer_name');
        $builder->join('tblgl_po as gl_po', 'gl_po.gl_id = gl.id');
        $builder->join('tblpurchaseorder as po', 'po.id = gl_po.po_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where('po.id',$po_id);
        $gl_list = $builder->get()->getResult();

        if(!$gl_list){
            return $emptyGl;
        }

        $gl_number_list = array_map(function ($gl) { return $gl->gl_number; }, $gl_list);
        $gl_number = implode(', ', $gl_number_list);

        $gl_number_list = array_map(function ($gl) { return $gl->buyer_name; }, $gl_list);
        $buyer_name = implode(', ', $gl_number_list);
        
        $result = (object)[
            'gl_number' => $gl_number,
            'buyer_name' => $buyer_name,
        ];
        return $result;
    }
}
