<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Location extends Migration
{
    private $table = 'tbllocation';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'location_name' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'description' => [
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
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
