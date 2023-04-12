<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Factory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'incharge' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'remarks' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tblfactory');
    }

    public function down()
    {
        //
    }
}
