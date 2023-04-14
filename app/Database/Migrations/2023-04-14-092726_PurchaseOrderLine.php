<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrderLine extends Migration
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
        'price' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
        ],
        'qty' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
        ],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('order_id', 'tblpo', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('product_id', 'tblproduct', 'product_id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('tbl_po_line');
    }

    public function down()
    {
        //
    }
}
