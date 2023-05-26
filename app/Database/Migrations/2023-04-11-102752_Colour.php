<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Colour extends Migration
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
            'colour_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('tblcolour');
    }

    public function down()
    {
        //menghapus tabel sizes
        $this->forge->dropTable('tblcolour');
    }
}
