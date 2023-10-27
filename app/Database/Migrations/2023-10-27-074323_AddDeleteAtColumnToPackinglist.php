<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteAtColumnToPackinglist extends Migration
{
    private $table_pl = 'tblpackinglist';
    private $table_pl_carton = 'tblpackinglistcarton';
    private $table_carton_detail = 'tblcartondetail';

    public function up()
    {
        $pl_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_pl, $pl_fields);
        
        $pl_carton_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_pl_carton, $pl_carton_fields);
        
        $carton_detail_fields = [
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table_carton_detail, $carton_detail_fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table_pl, ['deleted_at']);
        $this->forge->dropColumn($this->table_pl_carton, ['deleted_at']);
        $this->forge->dropColumn($this->table_carton_detail, ['deleted_at']);
    }
}
