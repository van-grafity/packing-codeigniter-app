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
            'PO_No' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'GL_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'Shipdate' => [
                'type' => 'DATE',
            ],
            'PO_Qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'PO_Amount' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->addForeignKey('GL_id', 'tblgl', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblpurchaseorder');
    }

    public function down()
    {
        $this->forge->dropTable('tblpurchaseorder');
    }
}
