<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAreaColumnToRackTable extends Migration
{
    private $table = 'tblrack';

    public function up()
    {
        $fields = [
            'area' => [
                'type' => 'char',
                'constraint' => 2,
                'null' => true,
                'after' => 'description',
            ],
            'level' => [
                'type' => 'int',
                'after' => 'area',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table, $fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table, ['area','level']);
    }
}
