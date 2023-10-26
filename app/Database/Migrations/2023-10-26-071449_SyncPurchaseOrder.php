<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SyncPurchaseOrder extends Migration
{
    private $table = 'tblsyncpurchaseorder';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'purchase_order_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'buyer_name' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'gl_number' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'season' => [
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
            'deleted_at'  => [
                'type' => 'datetime', 
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_order_id', 'tblpurchaseorder', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
