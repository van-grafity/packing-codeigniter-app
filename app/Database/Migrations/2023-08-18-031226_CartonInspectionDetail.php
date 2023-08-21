<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonInspectionDetail extends Migration
{
    private $table = 'tblcartoninspectiondetail';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'carton_inspection_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'carton_barcode_id' => [
                'type' => 'bigint',
                'unsigned' => true,
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
        $this->forge->addForeignKey('carton_inspection_id', 'tblcartoninspection', 'id');
        $this->forge->addForeignKey('carton_barcode_id', 'tblcartonbarcode', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
