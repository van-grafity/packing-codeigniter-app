<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteAtColumnToPalletTransfer extends Migration
{
    private $table_pallet_transfer = 'tblpallettransfer';
    private $table_transfer_note = 'tbltransfernote';
    private $table_transfer_note_detail = 'tbltransfernotedetail';

    public function up()
    {
        $pallet_transfer_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_pallet_transfer, $pallet_transfer_fields);
        
        $transfer_note_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_transfer_note, $transfer_note_fields);
        
        $transfer_note_detail_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_transfer_note_detail, $transfer_note_detail_fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table_pallet_transfer, ['deleted_at']);
        $this->forge->dropColumn($this->table_transfer_note, ['deleted_at']);
        $this->forge->dropColumn($this->table_transfer_note_detail, ['deleted_at']);
    }
}
