<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteAtColumnToPurchaseOrder extends Migration
{
    private $table_po = 'tblpurchaseorder';
    private $table_po_detail = 'tblpurchaseorderdetail';

    public function up()
    {
        $po_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_po, $po_fields);
        
        $po_detail_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_po_detail, $po_detail_fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table_po, ['deleted_at']);
        $this->forge->dropColumn($this->table_po_detail, ['deleted_at']);
    }
}
