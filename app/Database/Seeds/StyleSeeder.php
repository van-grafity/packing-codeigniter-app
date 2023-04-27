<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StyleSeeder extends Seeder
{
    private $table = 'tblstyles';

    private const DATA =[
        [
            'id' => 1,
            'style_no' => 'S001',
            'style_description' => 'AE-M-FW20-SHR-127-Micron-Medium',
            'style_gl_id' => 1,
        ],
        [
            'id' => 2,
            'style_no' => 'S002',
            'style_description' => 'AE-M-FW20-SHR-127-Micron-X-Small',
            'style_gl_id' => 2,
        ],
        [
            'id' => 3,
            'style_no' => 'S003',
            'style_description' => 'AE-M-FW20-SHR-127-Micron-Small',
            'style_gl_id' => 3,
        ],
        [
            'id' => 4,
            'style_no' => 'S004',
            'style_description' => 'Style 4',
            'style_gl_id' => 4,
        ],
        [
            'id' => 5,
            'style_no' => 'S005',
            'style_description' => 'Style 5',
            'style_gl_id' => 5,
        ],
        [
            'id' => 6,
            'style_no' => 'S006',
            'style_description' => 'Style 6',
            'style_gl_id' => 6,
        ],
        [
            'id' => 7,
            'style_no' => 'S007',
            'style_description' => 'Style 7',
            'style_gl_id' => 7,
        ],
        [
            'id' => 8,
            'style_no' => 'S008',
            'style_description' => 'Style 8',
            'style_gl_id' => 8,
        ],
        [
            'id' => 9,
            'style_no' => 'S009',
            'style_description' => 'Style 9',
            'style_gl_id' => 9,
        ],
        [
            'id' => 10,
            'style_no' => 'S010',
            'style_description' => 'Style 10',
            'style_gl_id' => 10,
        ],
        [
            'id' => 11,
            'style_no' => 'S011',
            'style_description' => 'Style 11',
            'style_gl_id' => 11,
        ],
        [
            'id' => 12,
            'style_no' => 'S012',
            'style_description' => 'Style 12',
            'style_gl_id' => 12,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
