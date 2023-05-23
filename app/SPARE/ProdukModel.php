<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'tblproduct';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['product_code', 'product_asin_id', 'product_style_id', 'product_name', 'product_price', 'product_category_id'];
}
