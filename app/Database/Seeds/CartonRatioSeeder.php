<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonRatioSeeder extends Seeder
{
    private $table = 'tblcartonratio';

    public const DATA = [
        [
            'id' => 1,
            'cartonbarcode_id' => 1,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:01',
            'updated_at' => '2023-04-19 17:30:01',
        ],
        [
            'id' => 2,
            'cartonbarcode_id' => 1,
            'size_id' => 2,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:02',
            'updated_at' => '2023-04-19 17:30:02',
        ],
        [
            'id' => 3,
            'cartonbarcode_id' => 1,
            'size_id' => 3,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:03',
            'updated_at' => '2023-04-19 17:30:03',
        ],
        [
            'id' => 4,
            'cartonbarcode_id' => 1,
            'size_id' => 4,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:04',
            'updated_at' => '2023-04-19 17:30:04',
        ],
        [
            'id' => 5,
            'cartonbarcode_id' => 1,
            'size_id' => 5,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:05',
            'updated_at' => '2023-04-19 17:30:05',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
