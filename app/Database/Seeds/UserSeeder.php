<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    private $table = 'tbluser';

    private const DATA = [
        [
            'id' => 1,
            'name' => 'Paul Bettany',
            'email' => 'paul@gmail.com',
            'password' => '123456',
            'role' => '1',
        ],
        [
            'id' => 2,
            'name' => 'Vanya',
            'email' => 'vanya@gmail.com',
            'password' => '123456',
            'role' => '1',
        ],
        [
            'id' => 3,
            'name' => 'Luther',
            'email' => 'luther@gmail.com',
            'password' => '123456',
            'role' => '1',
        ],
        [
            'id' => 4,
            'name' => 'John Doe',
            'email' => 'jhondoe@gmail.com',
            'password' => '123456',
            'role' => '1',
        ],
        [
            'id' => 5,
            'name' => 'Paul Bettany',
            'email' => 'paul@gmail.com',
            'password' => '123456',
            'role' => '1',
        ]
    ];
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
