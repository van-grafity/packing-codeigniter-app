<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{

    private $table = 'tblcategory';

    private const DATA = [
        [
            'category_id' => 1,
            'category_name' => 'T-Shirt',
        ],
        [
            'category_id' => 2,
            'category_name' => 'Polo Shirt',
        ],
        [
            'category_id' => 3,
            'category_name' => 'Leggings',
        ],
        [
            'category_id' => 4,
            'category_name' => 'Dress',
        ],
        [
            'category_id' => 5,
            'category_name' => 'Jacket',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
