<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpurchaseorder';

    private const DATA = [
        [
            'id' => 1,
            'PO_No' => '8X8WFHBM1',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-11-03',
            'unit_price' => 10.80,
            'PO_qty' => 10,
            'PO_amount' => 108,
            'created_at' => '2023-04-03 03:01:31',
            'updated_at' => NULL,
        ],
        [
            'id' => 2,
            'PO_No' => '8X8WFHBM2',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-11-03',
            'unit_price' => 10.80,
            'PO_qty' => 10,
            'PO_amount' => 108,
            'created_at' => '2023-04-03 03:01:31',
            'updated_at' => NULL,
        ],
        [
            'id' => 3,
            'PO_No' => '8X8WFHBM3',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-11-03',
            'unit_price' => 10.80,
            'PO_qty' => 10,
            'PO_amount' => 108,
            'created_at' => '2023-04-03 03:01:31',
            'updated_at' => NULL,
        ],
        [
            'id' => 4,
            'PO_No' => '8X8WFHBM4',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-11-03',
            'unit_price' => 10.80,
            'PO_qty' => 10,
            'PO_amount' => 108,
            'created_at' => '2023-04-03 03:01:31',
            'updated_at' => NULL,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
