<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GLSeeder extends Seeder
{
    private $table = 'tblgl';

    private const DATA = [
        [
            'id' => 1,
            'gl_number' => 'GL-62358-00',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - M',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
