<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PackingListSize extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'packinglistsize_pl_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'packinglistsize_size_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'packinglistsize_style_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'packinglistsize_qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'packinglistsize_amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('packinglistsize_pl_id', 'tblpackinglist', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('packinglistsize_size_id', 'tblsizes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('packinglistsize_style_id', 'tblstyles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblpackinglistsizes');
    }

    public function down()
    {
        $this->forge->dropTable('tblpackinglistsizes');
    }
}
