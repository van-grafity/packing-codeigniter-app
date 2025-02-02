<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpurchaseorder';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'po_no' => '8XW8FHBM',
                'shipdate' => '2022-08-16',
                'po_qty' => 395,
                'po_amount' => 4266,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'po_no' => '0000804646',
                'shipdate' => '2023-05-23',
                'po_qty' => 6284,
                'po_amount' => 34652,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
