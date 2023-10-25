<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSizeOrderColumnToSizeTable extends Migration
{
    private $table = 'tblsize';

    public function up()
    {
        $fields = [
            'size_order' => [
                'type' => 'int',
                'after' => 'size',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table, $fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table, ['size_order']);
    }
}
