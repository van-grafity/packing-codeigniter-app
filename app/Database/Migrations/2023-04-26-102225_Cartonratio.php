<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cartonratio extends Migration
{
    public function up()
    {
        //Membuat kolom/field untuk tabel Carton Ratio
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'cartonbarcode_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'size_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'ratio' => [
                'type' => 'INT',
                'constraint' => 2,
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
        $this->forge->addForeignKey('cartonbarcode_id', 'tblcartonbarcode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('size_id', 'tblsizes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblcartonratio');
    }

    public function down()
    {
        //menghapus tabel cartonratio
        $this->forge->dropTable('tblcartonratio');
    }
}
