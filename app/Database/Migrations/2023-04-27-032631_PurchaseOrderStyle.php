<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PurchaseOrderStyle extends Migration
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
            'style_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_order_id', 'tblpurchaseorder', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('style_id', 'tblstyles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblpurchaseorderstyle');
    }

    public function down()
    {
        $this->forge->dropTable('tblpurchaseorderstyle');
    }
}
