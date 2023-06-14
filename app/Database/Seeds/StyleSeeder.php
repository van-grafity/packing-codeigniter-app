<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StyleSeeder extends Seeder
{
    private $table = 'tblstyle';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'style_no' => 'AE-M-FW20-SHR-127',
                'style_description' => 'Amazon Essentials Disney Star Wars Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man',
            ],
            [
                'id' => 2,
                'style_no' => '5243AU11',
                'style_description' => 'SHORT SLEEVE POLOS',
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
