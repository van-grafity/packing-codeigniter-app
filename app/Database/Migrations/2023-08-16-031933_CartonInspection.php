<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonInspection extends Migration
{
    private $table = 'tblcartoninspection';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'carton_barcode_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'issued_by' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'received_by' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'received_at'  => [
                'type' => 'datetime',
            ],
            'repacked_at'  => [
                'type' => 'datetime', 
                'null' => true
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
        $this->forge->addForeignKey('carton_barcode_id', 'tblcartonbarcode', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
