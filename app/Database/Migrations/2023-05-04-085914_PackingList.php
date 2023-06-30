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
            'packinglist_number' => [
                'type' => 'int',
                'constraint' => 255,
            ],
            'packinglist_serial_number' => [
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
            'packinglist_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'packinglist_cutting_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'packinglist_ship_qty' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'packinglist_amount' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'destination' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'department' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'flag_generate_carton' => [
                'type' => 'char',
                'constraint' => '2',
                'default' => 'N',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('packinglist_po_id', 'tblpurchaseorder', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblpackinglist');
    }

    public function down()
    {
        $this->forge->dropTable('tblpackinglist');
    }
}
