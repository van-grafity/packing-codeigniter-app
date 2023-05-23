<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpurchaseorder';

    private const DATA = [
        [
            'id' => 1,
            'PO_No' => '8XW8FHBM',
            'GL_id' => 1,
            'Factory_id' => 1,
            'Shipdate' => '2022-11-03',
            'PO_Qty' => 395,
            'PO_Amount' => 4266,
            'created_at' => '2022-08-16 00:00:00',
            'updated_at' => NULL,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
