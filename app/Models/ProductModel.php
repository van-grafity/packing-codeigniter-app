<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'tblProduct';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'product_code',
        'product_asin_id',
        'product_style_id',
        'product_name',
        'product_price',
        'product_category_id',
    ];

    public function getCategory()
    {
        $builder = $this->db->table('tblcategory');
        return $builder->get();
    }

    public function getStyle()
    {
        $builder = $this->db->table('tblstyles');
        return $builder->get();
    }

    public function getColour()
    {
        $builder = $this->db->table('tblcolour');
        return $builder->get();
    }

    public function getSize()
    {
        $builder = $this->db->table('tblsizes');
        return $builder->get();
    }

    public function getProduct($code = false)
    {
        if ($code == false) {
            $builder = $this->db->table('tblproduct');
            $builder->select('tblproduct.*, tblstyles.style_description, tblcategory.category_name ');
            $builder->join('tblcategory', 'tblcategory.id = product_category_id', 'left');
            $builder->join('tblstyles', 'tblstyles.id = product_style_id', 'left');
            return $builder->get();
        }
        $builder = $this->db->table('tblproduct');
        $builder->select('tblproduct.*, tblstyles.style_description, tblcategory.category_name ');
        $builder->join('tblcategory', 'tblcategory.id = product_category_id', 'left');
        $builder->join('tblstyles', 'tblstyles.id = product_style_id', 'left');
        return $builder->where(['code' => $code])->get();
    }

    public function saveProduct($data)
    {
        $query = $this->db->table('tblproduct')->insert($data);
        return $query;
    }

    public function updateProduct($data, $id)
    {
        $query = $this->db->table('tblproduct')->update($data, array('id' => $id));
        return $query;
    }

    public function deleteProduct($id)
    {
        $query = $this->db->table('tblproduct')->delete(array('id' => $id));
        return $query;
    }

    public function getByPackinglist($po_id)
    {
        $builder = $this->db->table('tblproduct as product');
        $builder->select('product.*, colour.colour_name as colour, style.style_description as style, size.size, category.category_name as category');
        // $builder->select('product.*');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.product_id = product.id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->join('tblstyles as style', 'style.id = product.product_style_id');
        $builder->join('tblsizes as size', 'size.id = product.product_size_id');
        $builder->join('tblcategory as category', 'category.id = product.product_category_id');
        $builder->where('po_detail.order_id', $po_id);
        $builder->orderby('product.id','ASC');
        $builder->groupBy('product.id');
        $result = $builder->get()->getResult();
        return $result;
    }
}
