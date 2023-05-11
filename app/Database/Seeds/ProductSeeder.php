<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{

    private $table = 'tblproduct';

    private const DATA = [
        [
            'id' => 1,
            'product_code' => '193548003111',
            'product_asin_id' => 'B07HL25ZVB',
            'product_style_id' => 1,
            'product_name' => 'Spotted Zebra Girls Fleece Zip-Up Hoodie Sweatshirts, Unicorn',
            'product_price' => 7.2,
            'product_category_id' => 5,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 2,
            'product_code' => '195111263923',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 2,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 2',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 3,
            'product_code' => '195111263924',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 3,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 3',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 4,
            'product_code' => '195111263922',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 4,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 4',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 5,
            'product_code' => '195111263923',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 5,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 5',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 6,
            'product_code' => '195111263924',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 4,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 6',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 7,
            'product_code' => '195111263922',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 3,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 7',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 8,
            'product_code' => '195111263923',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 2,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 8',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 9,
            'product_code' => '195111263924',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 1,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 9',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 10,
            'product_code' => '195111263922',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 2,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 10',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 11,
            'product_code' => '195111263923',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 3,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 11',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
        [
            'id' => 12,
            'product_code' => '195111263924',
            'product_asin_id' => 'B08J66XGYV',
            'product_style_id' => 4,
            'product_name' => 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man 12',
            'product_price' => 10.80,
            'product_category_id' => 1,
            'created_at' => '2023-04-29 10:46:01',
            'updated_at' => '2023-04-29 10:46:01',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
