<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class colourSeeder extends Seeder
{
    private $table = 'tblcolour';

    public const DATA = [
        [
            'id' => 1,
            'colour_name' => 'Med Heather Grey',
            'created_at' => '2023-05-26 17:32:03',
            'updated_at' => '2023-05-26 17:32:03',
        ],
        [
            'id' => 2,
            'colour_name' => 'Dark Grey',
            'created_at' => '2023-05-26 17:32:03',
            'updated_at' => '2023-05-26 17:32:03',
        ],
        [
            'id' => 3,
            'colour_name' => 'Navy',
            'created_at' => '2023-05-26 17:32:03',
            'updated_at' => '2023-05-26 17:32:03',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
