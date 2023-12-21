<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePoAmountColumnInPurchaseOrder extends Migration
{
    private $table = 'tblpurchaseorder';

    public function up()
    {
        $fields = [
            'po_amount' => [
                'type' => 'float',
                'null' => true,
                'default' => 0,
            ],
        ];
        $this->forge->modifyColumn($this->table, $fields);
    }

    public function down()
    {
        $fields = [
            'po_amount' => [
                'type' => 'int',
                'null' => true,
                'default' => 0,
            ],
        ];
        $this->forge->modifyColumn($this->table, $fields);
    }
}
