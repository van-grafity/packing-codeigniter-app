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

    public function getOrCreateDataByName(Array $data_to_insert)
    {
        $StyleModel = model('StyleModel');
        $style_no = $data_to_insert['style_no'];
        $style_description = $data_to_insert['style_description'];
        
        $get_style = $StyleModel->where('style_no', $style_no)->first();
        if(!$get_style){
            $style_id = $StyleModel->insert([
                'style_no'=> $style_no,
                'style_description'=> $style_description,
            ]);
        } else {
            $style_id = $get_style['id'];
        }
        return $style_id;
    }

    public function getIdByName(String $name)
    {
        $StyleModel = model('StyleModel');
        $style_id = $StyleModel->where('style_no',$name)->first()['id'];
        return $style_id;
    }

    public function getStyleByGL($gl_id)
    {
        $builder = $this->db->table('tblgl');
        $builder->select('style.style_no, style.style_description');
        $builder->join('tblpurchaseorder as po', 'po.gl_id = tblgl.id');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.order_id = po.id');
        $builder->join('tblproduct as product', 'product.id = po_detail.product_id');
        $builder->join('tblstyle as style', 'style.id = product.product_style_id');
        $builder->where(['tblgl.id' => $gl_id]);
        $builder->groupBy('style.style_no, style.style_description');
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getStyleByPO($po_id)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->select('style.style_no, style.style_description');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.order_id = po.id');
        $builder->join('tblproduct as product', 'product.id = po_detail.product_id');
        $builder->join('tblstyle as style', 'style.id = product.product_style_id');
        $builder->where(['po.id' => $po_id]);
        $builder->groupBy('style.style_no, style.style_description');
        $result = $builder->get()->getResultArray();
        return $result;
    }
}
