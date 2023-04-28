<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrderSize extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'purchase_order_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'size_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_order_id', 'tblpurchaseorder', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('size_id', 'tblsizes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblpurchaseordersize');
    }

    public function down()
    {
        $this->forge->dropTable('tblpurchaseordersize');
    }
}
