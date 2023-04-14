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
            'PL_No' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'gl_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'PO_product_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'factory_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'shipdate' => [
                'type' => 'DATE',
            ],
            'unit_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'PO_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'PO_amount' => [
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
        $this->forge->addForeignKey('gl_id', 'tblgl', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('PO_product_id', 'tblproduct', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('factory_id', 'tblfactory', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblpo');
    }

    public function down()
    {
        //
    }
}
