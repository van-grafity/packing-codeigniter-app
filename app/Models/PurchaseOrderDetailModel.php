<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderDetailModel extends Model
{
    protected $table = 'tblpurchaseorderdetail';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = [
        'order_id',
        'product_id',
        'qty',
    ];
}
