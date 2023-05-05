<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderDetailSeeder extends Seeder
{
    private $table = 'tblpurchaseorderdetail';

    private const DATA = [
        [
            'id' => 1,
            'order_id' => 1,
            'style_id' => 1,
            'size_id' => 1,
            'product_id' => 1,
            'price' => 10.80,
            'qty' => 10,
        ],
        [
            'id' => 2,
            'order_id' => 1,
            'style_id' => 2,
            'size_id' => 2,
            'product_id' => 2,
            'price' => 10.80,
            'qty' => 116,
        ],
        [
            'id' => 3,
            'order_id' => 1,
            'style_id' => 3,
            'size_id' => 3,
            'product_id' => 3,
            'price' => 10.80,
            'qty' => 269,
        ],
        [
            'id' => 4,
            'order_id' => 2,
            'style_id' => 1,
            'size_id' => 1,
            'product_id' => 4,
            'price' => 10.80,
            'qty' => 269,
        ],
        [
            'id' => 5,
            'order_id' => 2,
            'style_id' => 2,
            'size_id' => 2,
            'product_id' => 5,
            'price' => 10.80,
            'qty' => 269,
        ],
        [
            'id' => 6,
            'order_id' => 3,
            'style_id' => 1,
            'size_id' => 2,
            'product_id' => 6,
            'price' => 10.80,
            'qty' => 269,
        ],
        [
            'id' => 7,
            'order_id' => 4,
            'style_id' => 1,
            'size_id' => 2,
            'product_id' => 7,
            'price' => 10.80,
            'qty' => 269,
        ],
    ];
        
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
