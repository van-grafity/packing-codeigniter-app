<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RackPallet extends Migration
{
    private $table = 'tblrackpallet';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'rack_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'pallet_transfer_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'flag_done'  => [
                'type' => 'char',
                'constraint' => 2,
                'default' => 'N',
            ],
            'created_at'  => [
                'type' => 'datetime', 
                'null' => true
            ],
            'updated_at'  => [
                'type' => 'datetime', 
                'null' => true
            ],
        ]);
        $this->forge->addForeignKey('rack_id', 'tblrack', 'id');
        $this->forge->addForeignKey('pallet_transfer_id', 'tblpallettransfer', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
