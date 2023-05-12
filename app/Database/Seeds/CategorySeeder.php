<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{

    private $table = 'tblcategory';

    private const DATA = [
        [
            'id' => 1,
            'category_name' => 'T-Shirt',
        ],
        [
            'id' => 2,
            'category_name' => 'Polo Shirt',
        ],
        [
            'id' => 3,
            'category_name' => 'Leggings',
        ],
        [
            'id' => 4,
            'category_name' => 'Dress',
        ],
        [
            'id' => 5,
            'category_name' => 'Jacket/Hoodie',
        ],
        [
            'id' => 6,
            'category_name' => 'Jumpsuit',
        ],
        [
            'id' => 7,
            'category_name' => 'Round Neck',
        ],
        [
            'id' => 8,
            'category_name' => 'V Neck',
        ],
        [
            'id' => 9,
            'category_name' => 'Boat Neck',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
