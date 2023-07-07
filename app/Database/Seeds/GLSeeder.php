<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GLSeeder extends Seeder
{
    private $table = 'tblgl';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'gl_number' => '62358-00',
                'season' => 'SS21',
                'style_id' => 1,
                'buyer_id' => 2,
                'size_order' => 'XS - M',
            ],
            [
                'id' => 2,
                'gl_number' => '62842-00',
                'season' => 'SUMMER 23',
                'style_id' => 2,
                'buyer_id' => 1,
                'size_order' => 'XS - XL',
            ],
            [
                'id' => 3,
                'gl_number' => '63169-00',
                'season' => "HOL'23",
                'style_id' => 2,
                'buyer_id' => 5,
                'size_order' => 'S - XL',
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
