<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransactionNumberColumnToPalletTransfer extends Migration
{
    private $table = 'tblpallettransfer';

    public function up()
    {
        $fields = [
            'transaction_number' => [
                'type' => 'varchar',
                'constraint' => 100,
                'after' => 'id',
            ],
        ];
        $this->forge->addColumn($this->table, $fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table, ['transaction_number']);
    }
}
