<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    private $table = 'users';

    private const DATA = [
        [
            'id' => 1,
            'name' => 'Paul Bettany',
            'email' => 'paul@gmail.com',
        ],
        [
            'id' => 2,
            'name' => 'Vanya',
            'email' => 'vanya@gmail.com',
        ],
        [
            'id' => 3,
            'name' => 'Luther',
            'email' => 'luther@gmail.com',
        ],
        [
            'id' => 4,
            'name' => 'John Doe',
            'email' => 'jhondoe@gmail.com',
        ],
        [
            'id' => 5,
            'name' => 'Paul Bettany',
            'email' => 'paul@gmail.com',
        ],
        [
            'id' => 6,
            'name' => 'Vanya',
            'email' => 'vanya@gmail.com',
        ],
        [
            'id' => 7,
            'name' => 'Luther',
            'email' => 'luther@gmail.com',
        ],
        [
            'id' => 8,
            'name' => 'John Doe',
            'email' => 'jhondoe@gmail.com',
        ]
    ];
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
