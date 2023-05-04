<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonBarcode extends Migration
{
    public function up()
    {
        //Membuat kolom/field untuk tabel CartonBarcode
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'carton_pl_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'carton_no' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'carton_barcode' => [
                'type' => 'BIGINT',
                'constraint' => 50,
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
        $this->forge->addForeignKey('carton_pl_id', 'tblpackinglist', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblcartonbarcode');
    }

    public function down()
    {
        //menghapus tabel cartonbarcode
        $this->forge->dropTable('tblcartonbarcode');
    }
}
