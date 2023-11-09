<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFlagLoadedToCartonBarcodeTable extends Migration
{
    private $table = 'tblcartonbarcode';

    public function up()
    {
        $fields = [
            'packed_at' => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'flag_packed',
            ],
            'flag_loaded' => [
                'type' => 'char',
                'constraint' => 2,
                'null' => true,
                'after' => 'packed_at',
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
        $this->forge->dropColumn($this->table, ['packed_at','flag_loaded','loaded_at']);
    }
}
