<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonRatioSeeder extends Seeder
{
    private $table = 'tblcartonratio';

    public const DATA = [
        [
            'id' => 1,
            'carton_pl_id' => 1,
            'carton_no' => 1,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:01',
            'updated_at' => '2023-04-19 17:30:01',
        ],
        [
            'id' => 2,
            'carton_pl_id' => 1,
            'carton_no' => 1,
            'size_id' => 2,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:02',
            'updated_at' => '2023-04-19 17:30:02',
        ],
        [
            'id' => 3,
            'carton_pl_id' => 1,
            'carton_no' => 1,
            'size_id' => 3,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:03',
            'updated_at' => '2023-04-19 17:30:03',
        ],
        [
            'id' => 4,
            'carton_pl_id' => 1,
            'carton_no' => 1,
            'size_id' => 4,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:04',
            'updated_at' => '2023-04-19 17:30:04',
        ],
        [
            'id' => 5,
            'carton_pl_id' => 1,
            'carton_no' => 2,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:05',
            'updated_at' => '2023-04-19 17:30:05',
        ],
        [
            'id' => 6,
            'carton_pl_id' => 1,
            'carton_no' => 2,
            'size_id' => 2,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:06',
            'updated_at' => '2023-04-19 17:30:06',
        ],
        [
            'id' => 7,
            'carton_pl_id' => 1,
            'carton_no' => 2,
            'size_id' => 3,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:07',
            'updated_at' => '2023-04-19 17:30:07',
        ],
        [
            'id' => 8,
            'carton_pl_id' => 1,
            'carton_no' => 2,
            'size_id' => 4,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:08',
            'updated_at' => '2023-04-19 17:30:08',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
