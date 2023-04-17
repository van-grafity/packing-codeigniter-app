<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpurchaseorder';

    private const DATA = [
        [
            'id' => 1,
            'PO_No' => '8X8WFHBM',
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
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-18',
            'unit_price' => 10.80,
            'PO_qty' => 116,
            'PO_amount' => 1253,
            'created_at' => '2023-04-03 03:01:42',
            'updated_at' => NULL,
        ],
        [
            'id' => 3,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:01:52',
            'updated_at' => NULL,
        ],
        [
            'id' => 4,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:02',
            'updated_at' => NULL,
        ],
        [
            'id' => 5,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:12',
            'updated_at' => NULL,
        ],
        [
            'id' => 6,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:22',
            'updated_at' => NULL,
        ],
        [
            'id' => 7,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:32',
            'updated_at' => NULL,
        ],
        [
            'id' => 8,
            'PO_No' => '8X8WFHBM',
            'gl_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:42',
            'updated_at' => NULL,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
