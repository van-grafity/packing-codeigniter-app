<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackingListSeeder extends Seeder
{
    private $table = 'tbl_packinglist';

    private const DATA = [
        [
            'packinglist_no' => 'PL-0001',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 1,
            'packinglist_product_id' => 1,
            'packinglist_qty' => 10,
            'packinglist_amount' => 100000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'packinglist_no' => 'PL-0002',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 2,
            'packinglist_product_id' => 2,
            'packinglist_qty' => 20,
            'packinglist_amount' => 200000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'packinglist_no' => 'PL-0003',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 3,
            'packinglist_product_id' => 3,
            'packinglist_qty' => 30,
            'packinglist_amount' => 300000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ],
        [
            'packinglist_no' => 'PL-0004',
            'packinglist_date' => '2021-04-16',
            'packinglist_po_id' => 4,
            'packinglist_product_id' => 4,
            'packinglist_qty' => 40,
            'packinglist_amount' => 400000,
            'packinglist_created_at' => '2021-04-16 15:38:09',
            'packinglist_updated_at' => '2021-04-16 15:38:09',
        ]
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
