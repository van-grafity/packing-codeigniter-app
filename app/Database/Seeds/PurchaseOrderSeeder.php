<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpurchaseorder';

    private const DATA = [
        [
            'id' => 1,
            'po_no' => '8XW8FHBM',
            'GL_id' => 1,
            'Shipdate' => '2022-08-16',
            'po_qty' => 395,
            'po_amount' => 4266,
            'created_at' => '2022-08-16 00:00:00',
            'updated_at' => NULL,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
