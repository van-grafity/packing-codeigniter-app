<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GLSeeder extends Seeder
{
    private $table = 'tblgl';

    private const DATA = [
        [
            'id' => 1,
            'gl_number' => 'GL-62358-001',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XXL',
        ],
        [
            'id' => 2,
            'gl_number' => 'GL-62358-002',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XXL',
        ],
        [
            'id' => 3,
            'gl_number' => 'GL-62358-003',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XXL',
        ],
        [
            'id' => 4,
            'gl_number' => 'GL-62359-001',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XL',
        ],
        [
            'id' => 5,
            'gl_number' => 'GL-62359-002',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XL',
        ],
        [
            'id' => 6,
            'gl_number' => 'GL-62359-003',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 1,
            'size_order' => 'XS - XL',
        ],
        [
            'id' => 7,
            'gl_number' => 'GL-62359-004',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - XL',
        ],
        [
            'id' => 8,
            'gl_number' => 'GL-62359-005',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - XL',
        ],
        [
            'id' => 9,
            'gl_number' => 'GL-62360-001',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - L',
        ],
        [
            'id' => 10,
            'gl_number' => 'GL-62360-002',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - L',
        ],
        [
            'id' => 11,
            'gl_number' => 'GL-62360-003',
            'season' => 'SS21',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - L',
        ],
        [
            'id' => 12,
            'gl_number' => 'GL-62360-004',
            'season' => 'SS22',
            'style_id' => 1,
            'buyer_id' => 2,
            'size_order' => 'XS - L',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
