<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonRatioSeeder extends Seeder
{
    private $table = 'tblcartonratio';

    public const DATA = [
        [
            'id' => 1,
            'carton_no' => 1,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:01',
            'updated_at' => '2023-04-19 17:30:01',
        ],
        [
            'id' => 2,
            'carton_no' => 1,
            'size_id' => 2,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:02',
            'updated_at' => '2023-04-19 17:30:02',
        ],
        [
            'id' => 3,
            'carton_no' => 1,
            'size_id' => 3,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:03',
            'updated_at' => '2023-04-19 17:30:03',
        ],
        [
            'id' => 4,
            'carton_no' => 1,
            'size_id' => 4,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:04',
            'updated_at' => '2023-04-19 17:30:04',
        ],
        [
            'id' => 5,
            'carton_no' => 1,
            'size_id' => 5,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:05',
            'updated_at' => '2023-04-19 17:30:05',
        ],
        [
            'id' => 6,
            'carton_no' => 2,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:06',
            'updated_at' => '2023-04-19 17:30:06',
        ],
        [
            'id' => 7,
            'carton_no' => 2,
            'size_id' => 12,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:07',
            'updated_at' => '2023-04-19 17:30:07',
        ],
        [
            'id' => 8,
            'carton_no' => 2,
            'size_id' => 3,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:08',
            'updated_at' => '2023-04-19 17:30:08',
        ],
        [
            'id' => 9,
            'carton_no' => 2,
            'size_id' => 4,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:09',
            'updated_at' => '2023-04-19 17:30:09',
        ],
        [
            'id' => 10,
            'carton_no_id' => 2,
            'size_id' => 5,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:10',
            'updated_at' => '2023-04-19 17:30:10',
        ],
        [
            'id' => 11,
            'carton_no_id' => 3,
            'size_id' => 1,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:11',
            'updated_at' => '2023-04-19 17:30:11',
        ],
        [
            'id' => 12,
            'carton_no_id' => 3,
            'size_id' => 2,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:12',
            'updated_at' => '2023-04-19 17:30:12',
        ],
        [
            'id' => 13,
            'carton_no_id' => 3,
            'size_id' => 3,
            'ratio' => 3,
            'created_at' => '2023-04-19 17:30:13',
            'updated_at' => '2023-04-19 17:30:13',
        ],
        [
            'id' => 14,
            'carton_no_id' => 3,
            'size_id' => 4,
            'ratio' => 2,
            'created_at' => '2023-04-19 17:30:14',
            'updated_at' => '2023-04-19 17:30:14',
        ],
        [
            'id' => 15,
            'carton_no_id' => 3,
            'size_id' => 5,
            'ratio' => 1,
            'created_at' => '2023-04-19 17:30:15',
            'updated_at' => '2023-04-19 17:30:15',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
