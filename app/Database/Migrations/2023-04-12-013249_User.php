<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// CREATE TABLE `users` (
//     `id` int NOT NULL COMMENT 'Primary Key',
//     `name` varchar(100) NOT NULL COMMENT 'Name',
//     `email` varchar(255) NOT NULL COMMENT 'Email Address'
//   ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='datatable demo table';

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
