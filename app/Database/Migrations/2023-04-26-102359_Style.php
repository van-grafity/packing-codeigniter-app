<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Style extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'style_no' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'style_description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'style_gl_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        // $this->forge->addForeignKey('style_gl_id', 'tblgl', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblstyles');
    }

    public function down()
    {
        $this->forge->dropTable('tblstyles');
    }
}
