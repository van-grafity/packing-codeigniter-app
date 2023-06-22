<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    private $table = 'tblrole';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'role' => [
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

        // ## add Role to Users Table

        $fields = [
            'role_id' => [
                'type' => 'bigint', 
                'unsigned' => true,
                'after' => 'active',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('tblusers', $fields);
        $this->forge->addForeignKey('role_id', 'tblrole', 'id');
        $this->forge->processIndexes('tblusers');
    }

    public function down()
    {
        $this->forge->dropForeignKey('tblusers', 'tblusers_role_id_foreign');
        $this->forge->dropColumn('tblusers', ['role_id']);

        $this->forge->dropTable($this->table);

    }
}
