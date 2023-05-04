<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSizeSeeder extends Seeder
{
    private $table = 'tblpurchaseordersize';

    private const DATA = [
        [
            'purchase_order_id' => 1,
            'size_id' => 4,
            'quantity' => 269
        ],
        [
            'purchase_order_id' => 1,
            'size_id' => 3,
            'quantity' => 10
        ],
        [
            'purchase_order_id' => 1,
            'size_id' => 2,
            'quantity' => 116
        ],
        [
            'purchase_order_id' => 2,
            'size_id' => 2,
            'quantity' => 40
        ],
        [
            'purchase_order_id' => 2,
            'size_id' => 3,
            'quantity' => 40
        ],
        [
            'purchase_order_id' => 2,
            'size_id' => 4,
            'quantity' => 40
        ],
        [
            'purchase_order_id' => 3,
            'size_id' => 5,
            'quantity' => 40
        ],
        [
            'purchase_order_id' => 3,
            'size_id' => 6,
            'quantity' => 40
        ],
        [
            'purchase_order_id' => 4,
            'size_id' => 7,
            'quantity' => 40
        ]
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
