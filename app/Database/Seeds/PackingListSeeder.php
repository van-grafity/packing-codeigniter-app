<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackingListSeeder extends Seeder
{
    private $table = 'tblpackinglist';

    private const DATA = [
        [
            'id' => 1,
            'packinglist_no' => 'PL-0001',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 1,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 100000,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
