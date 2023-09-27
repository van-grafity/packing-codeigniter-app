<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransferNote extends Migration
{
    private $table = 'tbltransfernote';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'pallet_transfer_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'serial_number' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'issued_by' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'authorized_by' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'received_by' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'received_at' => [
                'type' => 'datetime', 
                'null' => true
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
        $this->forge->addForeignKey('pallet_transfer_id', 'tblpallettransfer', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
