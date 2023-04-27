<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GLSeeder extends Seeder
{
    private $table = 'tblgl';

    private const DATA = [
        [
            'id' => 1,
            'gl_number' => 'GL-001',
            'season' => 'SS21',
            'size_order' => 'S',
            'buyer_id' => 1,
        ],
        [
            'id' => 2,
            'gl_number' => 'GL-002',
            'season' => 'SS21',
            'size_order' => 'M',
            'buyer_id' => 1,
        ],
        [
            'id' => 3,
            'gl_number' => 'GL-003',
            'season' => 'SS21',
            'size_order' => 'L',
            'buyer_id' => 1,
        ],
        [
            'id' => 4,
            'gl_number' => 'GL-004',
            'season' => 'SS21',
            'size_order' => 'XL',
            'buyer_id' => 1,
        ],
        [
            'id' => 5,
            'gl_number' => 'GL-005',
            'season' => 'SS21',
            'size_order' => 'XXL',
            'buyer_id' => 1,
        ],
        [
            'id' => 6,
            'gl_number' => 'GL-006',
            'season' => 'SS21',
            'size_order' => 'XXXL',
            'buyer_id' => 1,
        ],
        [
            'id' => 7,
            'gl_number' => 'GL-007',
            'season' => 'SS21',
            'size_order' => 'S',
            'buyer_id' => 2,
        ],
        [
            'id' => 8,
            'gl_number' => 'GL-008',
            'season' => 'SS21',
            'size_order' => 'M',
            'buyer_id' => 2,
        ],
        [
            'id' => 9,
            'gl_number' => 'GL-009',
            'season' => 'SS21',
            'size_order' => 'L',
            'buyer_id' => 2,
        ],
        [
            'id' => 10,
            'gl_number' => 'GL-010',
            'season' => 'SS21',
            'size_order' => 'XL',
            'buyer_id' => 2,
        ],
        [
            'id' => 11,
            'gl_number' => 'GL-011',
            'season' => 'SS21',
            'size_order' => 'XXL',
            'buyer_id' => 2,
        ],
        [
            'id' => 12,
            'gl_number' => 'GL-012',
            'season' => 'SS22',
            'size_order' => 'XXL',
            'buyer_id' => 2,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
