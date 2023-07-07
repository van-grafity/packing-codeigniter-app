<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'po_no' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'gl_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'shipdate' => [
                'type' => 'DATE',
            ],
            'po_qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
            ],
            'po_amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('gl_id', 'tblgl', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblpurchaseorder');
    }

    public function down()
    {
        $this->forge->dropTable('tblpurchaseorder');
    }
}
