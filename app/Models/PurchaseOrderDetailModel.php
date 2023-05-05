<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'purchaseorderdetails';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id',
        'style_id',
        'size_id',
        'product_id',
        'price',
        'qty',
    ];

    // Dates
    protected $useTimestamps = true;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
