<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonBarcode extends Migration
{
    private $table = 'tblcartonbarcode';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'packinglist_carton_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'carton_nuber_by_system' => [
                'type' => 'int',
            ],
            'carton_nuber_by_input' => [
                'type' => 'int',
            ],
            'barcode' => [
                'type' => 'varchar',
                'constraint' => 255,
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
        $this->forge->addForeignKey('packinglist_carton_id', 'tblpackinglistcarton', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
