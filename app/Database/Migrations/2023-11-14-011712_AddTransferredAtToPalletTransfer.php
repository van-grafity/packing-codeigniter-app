<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransferredAtToPalletTransfer extends Migration
{
    private $table = 'tblpallettransfer';

    public function up()
    {
        $fields = [
            'flag_ready_to_transfer' => [
                'type' => 'char',
                'constraint' => 2,
                'default' => 'N',
                'null' => true,
                'after' => 'location_to_id',
            ],
            'ready_to_transfer_at' => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'flag_ready_to_transfer',
            ],
            'transferred_at' => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'flag_transferred',
            ],
            'loaded_at' => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'flag_loaded',
            ],
        ];
        $this->forge->addColumn($this->table, $fields);
        
    }

    public function down()
    {
        $this->forge->dropColumn($this->table, ['transferred_at','loaded_at']);
    }
}
