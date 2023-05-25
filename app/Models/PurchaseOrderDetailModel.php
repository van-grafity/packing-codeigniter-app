<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderDetailModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblpurchaseorderdetail';
    protected $allowedFields = [
        'order_id',
        'product_id',
        'size_id',
        'qty',
    ];
}
