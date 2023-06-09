<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sizes extends Migration
{
    public function up()
    {
        //Membuat kolom/field untuk tabel sizes
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('tblsize');
    }

    public function down()
    {
        //menghapus tabel sizes
        $this->forge->dropTable('tblsize');
    }
}
