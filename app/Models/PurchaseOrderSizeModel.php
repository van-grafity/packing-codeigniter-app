<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderSizeModel extends Model
{
    protected $table            = 'purchaseordersizes';
    protected $allowedFields    = [
        'purchase_order_id',
        'size_id',
        'quantity'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'purchase_order_id' => 'required|is_natural_no_zero',
        'size_id' => 'required|is_natural_no_zero',
        'quantity' => 'required|is_natural_no_zero'
    ];
    protected $validationMessages   = [
        'purchase_order_id' => [
            'required' => 'Purchase Order ID is required',
            'is_natural_no_zero' => 'Purchase Order ID must be a natural number greater than zero'
        ],
        'size_id' => [
            'required' => 'Size ID is required',
            'is_natural_no_zero' => 'Size ID must be a natural number greater than zero'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'is_natural_no_zero' => 'Quantity must be a natural number greater than zero'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
