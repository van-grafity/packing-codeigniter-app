<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransferNoteDetail extends Migration
{
    private $table = 'tbltransfernotedetail';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'transfer_note_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'carton_barcode_id' => [
                'type' => 'bigint',
                'unsigned' => true,
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
        $this->forge->addForeignKey('transfer_note_id', 'tbltransfernote', 'id');
        $this->forge->addForeignKey('carton_barcode_id', 'tblcartonbarcode', 'id');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
