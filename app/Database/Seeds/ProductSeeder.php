<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{

    private $table = 'tblproduct';

    private const DATA = [
        [
            'id' => 1,
            'product_code' => '195111263922',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 1,
            'product_name' => 'Fleece Pullover Hoodie Sweatshirts',
            'product_price' => 10.8,
            'product_category_id' => 5,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 2,
            'product_code' => '195111263939',
            'product_asin_id' => 'B08J5GGYGK',
            'product_style_id' => 1,
            'product_name' => 'Fleece Pullover Hoodie Sweatshirts',
            'product_price' => 10.8,
            'product_category_id' => 5,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 3,
            'product_code' => '195111263946',
            'product_asin_id' => 'B08J6C297M',
            'product_style_id' => 1,
            'product_name' => 'Fleece Pullover Hoodie Sweatshirts',
            'product_price' => 10.8,
            'product_category_id' => 5,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
