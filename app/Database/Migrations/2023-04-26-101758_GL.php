<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GL extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'gl_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'season' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'size_order' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'buyer_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('buyer_id', 'tblbuyer', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblgl');
    }

    public function down()
    {
        $this->forge->dropTable('tblgl');
    }
}
