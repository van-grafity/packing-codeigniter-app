<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class sizeSeeder extends Seeder
{
    private $table = 'tblsizes';

    public const DATA = [
        [
            'id' => 1,
            'size' => 'XS',
            'created_at' => '2023-04-19 17:32:02',
            'updated_at' => '2023-04-19 17:32:02',
        ],
        [
            'id' => 2,
            'size' => 'S',
            'created_at' => '2023-04-19 17:32:03',
            'updated_at' => '2023-04-19 17:32:03',
        ],
        [
            'id' => 3,
            'size' => 'M',
            'created_at' => '2023-04-19 17:32:04',
            'updated_at' => '2023-04-19 17:32:04',
        ],
        [
            'id' => 4,
            'size' => 'L',
            'created_at' => '2023-04-19 17:32:05',
            'updated_at' => '2023-04-19 17:32:05',
        ],
        [
            'id' => 5,
            'size' => 'XL',
            'created_at' => '2023-04-19 17:32:06',
            'updated_at' => '2023-04-19 17:32:06',
        ],
        [
            'id' => 6,
            'size' => 'XXL',
            'created_at' => '2023-04-19 17:32:07',
            'updated_at' => '2023-04-19 17:32:07',
        ],
        [
            'id' => 7,
            'size' => 'XXXL',
            'created_at' => '2023-04-19 17:32:08',
            'updated_at' => '2023-04-19 17:32:08',
        ],
        [
            'id' => 8,
            'size' => '2',
            'created_at' => '2023-04-19 17:32:09',
            'updated_at' => '2023-04-19 17:32:09',
        ],
        [
            'id' => 9,
            'size' => '4',
            'created_at' => '2023-04-19 17:32:10',
            'updated_at' => '2023-04-19 17:32:10',
        ],
        [
            'id' => 10,
            'size' => '6',
            'created_at' => '2023-04-19 17:32:11',
            'updated_at' => '2023-04-19 17:32:11',
        ],
        [
            'id' => 11,
            'size' => '8',
            'created_at' => '2023-04-19 17:32:12',
            'updated_at' => '2023-04-19 17:32:12',
        ],
        [
            'id' => 12,
            'size' => '10',
            'created_at' => '2023-04-19 17:32:13',
            'updated_at' => '2023-04-19 17:32:13',
        ],
        [
            'id' => 13,
            'size' => '12',
            'created_at' => '2023-04-19 17:32:14',
            'updated_at' => '2023-04-19 17:32:14',
        ],
        [
            'id' => 14,
            'size' => '14',
            'created_at' => '2023-04-19 17:32:15',
            'updated_at' => '2023-04-19 17:32:15',
        ],
        [
            'id' => 15,
            'size' => '16',
            'created_at' => '2023-04-19 17:32:16',
            'updated_at' => '2023-04-19 17:32:16',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
