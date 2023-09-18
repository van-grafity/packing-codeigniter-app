<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PalletTransfer extends Migration
{
    private $table = 'tblpallettransfer';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'pallet_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'location_from_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'location_to_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],  
            'flag_transferred'  => [
                'type' => 'char',
                'constraint' => 2,
            ],
            'flag_loaded'  => [
                'type' => 'char',
                'constraint' => 2,
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pallet_id', 'tblpallet', 'id');
        $this->forge->addForeignKey('location_from_id', 'tbllocation', 'id');
        $this->forge->addForeignKey('location_to_id', 'tbllocation', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
