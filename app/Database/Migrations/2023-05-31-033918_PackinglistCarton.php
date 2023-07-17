<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PackinglistCarton extends Migration
{
    private $table = 'tblpackinglistcarton';

    public function up()
    {
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
            'carton_qty' => [
                'type' => 'int',
            ],
            'gross_weight' => [
                'type' => 'float',
            ],
            'net_weight' => [
                'type' => 'float',
            ],
            'carton_number_from' => [
                'type' => 'int',
            ],
            'carton_number_to' => [
                'type' => 'int',
            ],
            'flag_generate_carton' => [
                'type' => 'char',
                'constraint' => '2',
                'default' => 'N',
            ],
            'measurement_ctn' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
