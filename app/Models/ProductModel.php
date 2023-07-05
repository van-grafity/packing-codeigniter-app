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
        'product_category_id',
        'product_style_id',
        'product_colour_id',
        'product_size_id',
        'product_name',
        'product_price',
    ];

    public function getProduct($code = false)
    {
        $builder = $this->db->table('tblproduct');
        $builder->select('tblproduct.*, tblstyle.style_description, tblcategory.category_name, tblsize.size as product_size');
        $builder->join('tblcategory', 'tblcategory.id = product_category_id', 'left');
        $builder->join('tblstyle', 'tblstyle.id = product_style_id', 'left');
        $builder->join('tblcolour', 'tblcolour.id = product_colour_id', 'left');
        $builder->join('tblsize', 'tblsize.id = product_size_id', 'left');
        if ($code) {
            $builder->where(['code' => $code]);
        }
        $builder->orderBy('created_at','DESC');
        return $builder->get();
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

    public function getByPurchaseOrderID($po_id)
    {
        $builder = $this->db->table('tblproduct as product');
        $builder->select('product.*, colour.colour_name as colour, style.style_description as style, size.size, category.category_name as category');
        // $builder->select('product.*');
        $builder->join('tblpurchaseorderdetail as po_detail', 'po_detail.product_id = product.id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->join('tblstyle as style', 'style.id = product.product_style_id');
        $builder->join('tblsize as size', 'size.id = product.product_size_id');
        $builder->join('tblcategory as category', 'category.id = product.product_category_id');
        $builder->where('po_detail.order_id', $po_id);
        $builder->orderby('product.id', 'ASC');
        $builder->groupBy('product.id');
        $result = $builder->get()->getResult();
        return $result;
    }

    public function insertProduct($data_array)
    {
        $additionalUpdateField = ['updated_at' => new RawSql('CURRENT_TIMESTAMP')];
        $builder = $this->db->table('tblcartonbarcode');
        $builder->updateFields($additionalUpdateField, true);
        $result = $builder->updateBatch($data_array, ['packinglist_id', 'carton_number_by_system']);
        return $result;
    }
}
