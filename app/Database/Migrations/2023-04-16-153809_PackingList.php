<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PackingList extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'packinglist_no' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'packinglist_date' => [
                'type' => 'DATE',
            ],
            'packinglist_po_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'packinglist_product_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'packinglist_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'packinglist_amount' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'packinglist_created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'packinglist_updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('packinglist_po_id', 'tblpo', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('packinglist_product_id', 'tblproduct', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_packinglist');
    }

    public function down()
    {
        //
    }
}
