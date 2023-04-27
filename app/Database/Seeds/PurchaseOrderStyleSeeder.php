<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderStyleSeeder extends Seeder
{
    private $table = 'tblpurchaseorderstyle';

    private const DATA = [
        [
            'id' => 1,
            'purchase_order_id' => 1,
            'style_id' => 1,
        ],
        [
            'id' => 2,
            'purchase_order_id' => 1,
            'style_id' => 2,
        ],
        [
            'id' => 3,
            'purchase_order_id' => 1,
            'style_id' => 3,
        ],
        [
            'id' => 4,
            'purchase_order_id' => 4,
            'style_id' => 4,
        ]
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
