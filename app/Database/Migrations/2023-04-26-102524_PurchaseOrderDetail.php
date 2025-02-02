<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrderDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
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
        $this->forge->addForeignKey('order_id', 'tblpurchaseorder', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('product_id', 'tblproduct', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblpurchaseorderdetail');
    }

    public function down()
    {
        $this->forge->dropTable('tblpurchaseorderdetail');
    }
}
