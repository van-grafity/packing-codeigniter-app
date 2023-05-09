<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Buyer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'buyer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'offadd' => [
                'type' => 'VARCHAR',
                'constraint' => 75,
            ],
            'shipadd' => [
                'type' => 'VARCHAR',
                'constraint' => 75,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tblbuyer');
    }

    public function down()
    {
        $this->forge->dropTable('tblbuyer');
    }
}
