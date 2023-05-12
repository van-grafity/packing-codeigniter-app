<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StyleSeeder extends Seeder
{
    private $table = 'tblstyles';

    private const DATA = [
        [
            'id' => 1,
            'style_no' => 'S001',
            'style_description' => 'AE-M-FW20-SHR-127',
        ],
        [
            'id' => 2,
            'style_no' => 'S002',
            'style_description' => 'AE-M-FW20-SHR-128',
        ],
        [
            'id' => 3,
            'style_no' => 'S003',
            'style_description' => 'AE-M-FW20-SHR-129',
        ],
        [
            'id' => 4,
            'style_no' => 'S004',
            'style_description' => 'Style 4',
        ],
        [
            'id' => 5,
            'style_no' => 'S005',
            'style_description' => 'Style 5',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
