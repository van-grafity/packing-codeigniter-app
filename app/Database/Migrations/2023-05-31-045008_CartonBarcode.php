<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonBarcode extends Migration
{
    private $table = 'tblcartonbarcode';

    public function up()
    {
        // ## ada column packinglist_id adalah untuk kebutuhan insertbatch saat insert carton via excel
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'packinglist_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'packinglist_carton_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'carton_number_by_system' => [
                'type' => 'int',
                'null' => true,
            ],
            'carton_number_by_input' => [
                'type' => 'int',
                'null' => true,
            ],
            'barcode' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'flag_packed' => [
                'type' => 'char',
                'default' => 'N',
                'constraint' => 2,
            ],
            'created_at'  => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at'  => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('packinglist_id', 'tblpackinglist', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('packinglist_carton_id', 'tblpackinglistcarton', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
