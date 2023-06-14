<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    private $table = 'tblusers';

    private const DATA = [
        [
            'id' => 1,
            'email' => 'admin@ghimli.com',
            'new_email' => NULL,
            'password_hash' => '$2y$10$/clmNLUUxGnREFHqraU7P.aVfJ5Mk0iEKRgKVz8.ZKOZIUGJGXlya',
            'name' => 'Admin',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'activate_hash' => 'ZEWv2TUIY5oDqgw9FkjnmAS78zJNKfpL',
            'reset_hash' => NULL,
            'reset_expires' => Null,
            'active' => 1,
            'created_at' => '2023-06-12 21:07:50',
            'updated_at' => '2023-06-12 21:07:50',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
