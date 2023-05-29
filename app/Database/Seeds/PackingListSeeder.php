<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackingListSeeder extends Seeder
{
    private $table = 'tblpackinglist';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'packinglist_number' => 1,
                'packinglist_serial_number' => 'PL-2305-001',
                'packinglist_date' => '2021-05-01',
                'packinglist_po_id' => 1,
                'packinglist_qty' => 395,
                'packinglist_cutting_qty' => 395,
                'packinglist_ship_qty' => 395,
                'packinglist_amount' => 100000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'packinglist_number' => 2,
                'packinglist_serial_number' => 'PL-2305-002',
                'packinglist_date' => '2021-05-01',
                'packinglist_po_id' => 1,
                'packinglist_qty' => 395,
                'packinglist_cutting_qty' => 395,
                'packinglist_ship_qty' => 395,
                'packinglist_amount' => 100000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'packinglist_number' => 3,
                'packinglist_serial_number' => 'PL-2305-003',
                'packinglist_date' => '2021-05-02',
                'packinglist_po_id' => 1,
                'packinglist_qty' => 395,
                'packinglist_cutting_qty' => 395,
                'packinglist_ship_qty' => 395,
                'packinglist_amount' => 100000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
