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
                'packinglist_date' => date('Y-m-d H:i:s'),
                'packinglist_po_id' => 1,
                'packinglist_qty' => 395,
                'packinglist_cutting_qty' => 395,
                'packinglist_ship_qty' => 395,
                'packinglist_amount' => 100000,
                'destination' => 'LGB1 - Long Beach, CA',
                'department' => 'Walmart 33 / Ladies',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'packinglist_number' => 2,
                'packinglist_serial_number' => 'PL-2305-002',
                'packinglist_date' => date('Y-m-d H:i:s'),
                'packinglist_po_id' => 2,
                'packinglist_qty' => 6284,
                'packinglist_cutting_qty' => 6284,
                'packinglist_ship_qty' => 6284,
                'packinglist_amount' => 34652,
                'destination' => 'AERO PRO RECEIVING WEST 950 N BARRINGTON AVE ONTARIO, CA 91764 US',
                'department' => '843 AERO GIRLS POLOS',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
