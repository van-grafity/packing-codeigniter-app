<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteAtColumnToCartonBarcode extends Migration
{
    private $table_carton_barcode = 'tblcartonbarcode';

    public function up()
    {
        $pl_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_carton_barcode, $pl_fields);
        
    }

    public function down()
    {
        $this->forge->dropColumn($this->table_carton_barcode, ['deleted_at']);
    }
}
