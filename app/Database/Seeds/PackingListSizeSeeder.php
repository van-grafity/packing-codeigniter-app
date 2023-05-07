<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackingListSizeSeeder extends Seeder
{
    private $table = 'tblpackinglistsizes';

    public const DATA = [
        [
            'id' => 1,
            'packinglistsize_pl_id' => 1,
            'packinglistsize_size_id' => 1,
            'packinglistsize_style_id' => 1,
            'packinglistsize_qty' => 10,
            'packinglistsize_amount' => 1000,
            'created_at' => '2023-04-19 17:32:02',
            'updated_at' => '2023-04-19 17:32:02',
        ],
        [
            'id' => 2,
            'packinglistsize_pl_id' => 1,
            'packinglistsize_size_id' => 2,
            'packinglistsize_style_id' => 2,
            'packinglistsize_qty' => 20,
            'packinglistsize_amount' => 1000,
            'created_at' => '2023-04-19 17:32:03',
            'updated_at' => '2023-04-19 17:32:03',
        ],
        [
            'id' => 3,
            'packinglistsize_pl_id' => 1,
            'packinglistsize_size_id' => 3,
            'packinglistsize_style_id' => 3,
            'packinglistsize_qty' => 100,
            'packinglistsize_amount' => 1000,
            'created_at' => '2023-04-19 17:32:04',
            'updated_at' => '2023-04-19 17:32:04',
        ],
        [
            'id' => 4,
            'packinglistsize_pl_id' => 1,
            'packinglistsize_size_id' => 4,
            'packinglistsize_style_id' => 4,
            'packinglistsize_qty' => 100,
            'packinglistsize_amount' => 1000,
            'created_at' => '2023-04-19 17:32:05',
            'updated_at' => '2023-04-19 17:32:05',
        ],
        [
            'id' => 5,
            'packinglistsize_pl_id' => 1,
            'packinglistsize_size_id' => 5,
            'packinglistsize_style_id' => 5,
            'packinglistsize_qty' => 100,
            'packinglistsize_amount' => 1000,
            'created_at' => '2023-04-19 17:32:06',
            'updated_at' => '2023-04-19 17:32:06',
        ]
    ];
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
