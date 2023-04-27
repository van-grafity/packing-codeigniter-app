<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderStyleModel extends Model
{
    protected $table            = 'tblpurchaseorderstyle';
    protected $allowedFields    = [
        'purchase_order_id',
        'style_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'purchase_order_id' => 'required|is_natural_no_zero',
        'style_id' => 'required|is_natural_no_zero'
    ];
    protected $validationMessages   = [
        'purchase_order_id' => [
            'required' => 'Purchase Order ID is required',
            'is_natural_no_zero' => 'Purchase Order ID must be a natural number greater than zero'
        ],
        'style_id' => [
            'required' => 'Style ID is required',
            'is_natural_no_zero' => 'Style ID must be a natural number greater than zero'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
