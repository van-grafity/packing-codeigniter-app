<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    private $table = 'tblusers';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'email' => 'admin@ghimli.com',
                'new_email' => NULL,
                'password_hash' => password_hash('ghimli@2024', PASSWORD_DEFAULT),
                'name' => 'Admin',
                'firstname' => 'Admin',
                'lastname' => 'User',
                'activate_hash' => random_string('alnum', 32),
                'reset_hash' => NULL,
                'reset_expires' => Null,
                'active' => 1,
                'role_id' => 1,
                'created_at' => '2023-06-12 21:07:50',
                'updated_at' => '2023-06-12 21:07:50',
            ],
            [
                'id' => 2,
                'email' => 'itprogrammer@ghimli.com',
                'new_email' => NULL,
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'name' => 'IT Programmer',
                'firstname' => 'IT',
                'lastname' => 'Programmer',
                'activate_hash' => random_string('alnum', 32),
                'reset_hash' => NULL,
                'reset_expires' => Null,
                'active' => 1,
                'role_id' => 1,
                'created_at' => '2023-06-12 21:07:50',
                'updated_at' => '2023-06-12 21:07:50',
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
