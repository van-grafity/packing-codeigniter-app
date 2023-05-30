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
            'size_id' => 1,
            'product_id' => 1,
            'qty' => 10,
        ],
        [
            'id' => 2,
            'order_id' => 1,
            'size_id' => 2,
            'product_id' => 2,
            'qty' => 116,
        ],
        [
            'id' => 3,
            'order_id' => 1,
            'size_id' => 3,
            'product_id' => 3,
            'qty' => 269,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
