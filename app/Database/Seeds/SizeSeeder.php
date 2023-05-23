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
            'created_at' => '2023-04-19 17:32:03',
            'updated_at' => '2023-04-19 17:32:03',
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
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
