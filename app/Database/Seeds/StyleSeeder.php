<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StyleSeeder extends Seeder
{
    private $table = 'tblstyle';

    private const DATA = [
        [
            'id' => 1,
            'style_no' => 'AE-M-FW20-SHR-127',
            'style_description' => 'Amazon Essentials Disney Star Wars Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
