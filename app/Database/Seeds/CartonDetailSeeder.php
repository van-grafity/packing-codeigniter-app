<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonDetailSeeder extends Seeder
{
    private $table = 'tblcartondetail';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'packinglist_carton_id' => 1,
                'product_id' => 1,
                'product_qty' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'packinglist_carton_id' => 2,
                'product_id' => 2,
                'product_qty' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'packinglist_carton_id' => 3,
                'product_id' => 2,
                'product_qty' => 16,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'packinglist_carton_id' => 4,
                'product_id' => 3,
                'product_qty' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'packinglist_carton_id' => 5,
                'product_id' => 3,
                'product_qty' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
