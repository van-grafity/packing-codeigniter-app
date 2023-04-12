<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderDetailSeeder extends Seeder
{
    private $table = 'tblpo_detail';

    private const DATA = [
        [
            'order_id' => 1,
            'product_id' => 1,
            'price' => 100,
            'qty' => 1,
        ],
        [
            'order_id' => 1,
            'product_id' => 2,
            'price' => 200,
            'qty' => 2,
        ],
        [
            'order_id' => 2,
            'product_id' => 3,
            'price' => 300,
            'qty' => 3,
        ],
        [
            'order_id' => 2,
            'product_id' => 4,
            'price' => 400,
            'qty' => 4,
        ],
        [
            'order_id' => 3,
            'product_id' => 5,
            'price' => 500,
            'qty' => 5,
        ],
        [
            'order_id' => 3,
            'product_id' => 6,
            'price' => 600,
            'qty' => 6,
        ],
    ];
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
