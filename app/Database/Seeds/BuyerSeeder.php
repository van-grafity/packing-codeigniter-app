<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BuyerSeeder extends Seeder
{
    private $table = 'tblbuyer';

    private const DATA = [
        [
            'id' => 1,
            'buyer_name' => 'AMAZON "ESSENTIALS"',
            'offadd' => 'Office Address 1',
            'shipadd' => 'Shipping Address 1',
            'country' => 'Country 1',
        ],
        [
            'id' => 2,
            'buyer_name' => 'Buyer 2',
            'offadd' => 'Office Address 2',
            'shipadd' => 'Shipping Address 2',
            'country' => 'Country 2',
        ],
        [
            'id' => 3,
            'buyer_name' => 'Buyer 3',
            'offadd' => 'Office Address 3',
            'shipadd' => 'Shipping Address 3',
            'country' => 'Country 3',
        ],
        [
            'id' => 4,
            'buyer_name' => 'Buyer 4',
            'offadd' => 'Office Address 4',
            'shipadd' => 'Shipping Address 4',
            'country' => 'Country 4',
        ],
        [
            'id' => 5,
            'buyer_name' => 'Buyer 5',
            'offadd' => 'Office Address 5',
            'shipadd' => 'Shipping Address 5',
            'country' => 'Country 5',
        ],
        [
            'id' => 6,
            'buyer_name' => 'Buyer 6',
            'offadd' => 'Office Address 6',
            'shipadd' => 'Shipping Address 6',
            'country' => 'Country 6',
        ],
        [
            'id' => 7,
            'buyer_name' => 'Buyer 7',
            'offadd' => 'Office Address 7',
            'shipadd' => 'Shipping Address 7',
            'country' => 'Country 7',
        ],
        [
            'id' => 8,
            'buyer_name' => 'Buyer 8',
            'offadd' => 'Office Address 8',
            'shipadd' => 'Shipping Address 8',
            'country' => 'Country 8',
        ],
        [
            'id' => 9,
            'buyer_name' => 'Buyer 9',
            'offadd' => 'Office Address 9',
            'shipadd' => 'Shipping Address 9',
            'country' => 'Country 9',
        ],
        [
            'id' => 10,
            'buyer_name' => 'Buyer 10',
            'offadd' => 'Office Address 10',
            'shipadd' => 'Shipping Address 10',
            'country' => 'Country 10',
        ],
        [
            'id' => 11,
            'buyer_name' => 'Buyer 11',
            'offadd' => 'Office Address 11',
            'shipadd' => 'Shipping Address 11',
            'country' => 'Country 11',
        ],
        [
            'id' => 12,
            'buyer_name' => 'Buyer 12',
            'offadd' => 'Office Address 12',
            'shipadd' => 'Shipping Address 12',
            'country' => 'Country 12',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
