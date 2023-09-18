<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pallet extends Migration
{
    private $table = 'tblpallet';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'serial_number' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'flag_empty'  => [
                'type' => 'char',
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
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
