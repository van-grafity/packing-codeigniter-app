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
            'packinglist_style_id' => 1,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 100000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'id' => 2,
            'packinglist_no' => 'PL-0002',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 1,
            'packinglist_style_id' => 2,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 200000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'id' => 3,
            'packinglist_no' => 'PL-0003',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 1,
            'packinglist_style_id' => 3,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 300000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'id' => 4,
            'packinglist_no' => 'PL-0004',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 2,
            'packinglist_style_id' => 4,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 400000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'id' => 5,
            'packinglist_no' => 'PL-0005',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 2,
            'packinglist_style_id' => 5,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 500000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'id' => 6,
            'packinglist_no' => 'PL-0006',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 3,
            'packinglist_style_id' => 4,
            'packinglist_qty' => 395,
            'packinglist_cutting_qty' => 395,
            'packinglist_ship_qty' => 395,
            'packinglist_amount' => 600000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
