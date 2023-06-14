<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderDetailSeeder extends Seeder
{
    private $table = 'tblpurchaseorderdetail';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'order_id' => 1,
                'size_id' => 1,
                'product_id' => 1,
                'qty' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'order_id' => 1,
                'size_id' => 2,
                'product_id' => 2,
                'qty' => 116,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'order_id' => 1,
                'size_id' => 3,
                'product_id' => 3,
                'qty' => 269,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'order_id' => 2,
                'size_id' => 1,
                'product_id' => 4,
                'qty' => 192,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'order_id' => 2,
                'size_id' => 2,
                'product_id' => 5,
                'qty' => 475,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'order_id' => 2,
                'size_id' => 3,
                'product_id' => 6,
                'qty' => 859,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'order_id' => 2,
                'size_id' => 4,
                'product_id' => 7,
                'qty' => 859,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 8,
                'order_id' => 2,
                'size_id' => 5,
                'product_id' => 8,
                'qty' => 667,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 9,
                'order_id' => 2,
                'size_id' => 1,
                'product_id' => 9,
                'qty' => 204,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 10,
                'order_id' => 2,
                'size_id' => 2,
                'product_id' => 10,
                'qty' => 502,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 11,
                'order_id' => 2,
                'size_id' => 3,
                'product_id' => 11,
                'qty' => 910,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 12,
                'order_id' => 2,
                'size_id' => 4,
                'product_id' => 12,
                'qty' => 910,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 13,
                'order_id' => 2,
                'size_id' => 5,
                'product_id' => 13,
                'qty' => 706,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
