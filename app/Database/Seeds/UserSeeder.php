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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'email' => 'merchandiser@ghimli.com',
                'new_email' => NULL,
                'password_hash' => password_hash('123456789', PASSWORD_DEFAULT),
                'name' => 'merchandiser',
                'firstname' => 'merchandiser',
                'lastname' => 'tester',
                'activate_hash' => random_string('alnum', 32),
                'reset_hash' => NULL,
                'reset_expires' => Null,
                'active' => 1,
                'role_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'email' => 'packing@ghimli.com',
                'new_email' => NULL,
                'password_hash' => password_hash('123456789', PASSWORD_DEFAULT),
                'name' => 'packing',
                'firstname' => 'packing',
                'lastname' => 'tester',
                'activate_hash' => random_string('alnum', 32),
                'reset_hash' => NULL,
                'reset_expires' => Null,
                'active' => 1,
                'role_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'email' => 'shipping@ghimli.com',
                'new_email' => NULL,
                'password_hash' => password_hash('123456789', PASSWORD_DEFAULT),
                'name' => 'shipping',
                'firstname' => 'shipping',
                'lastname' => 'tester',
                'activate_hash' => random_string('alnum', 32),
                'reset_hash' => NULL,
                'reset_expires' => Null,
                'active' => 1,
                'role_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
