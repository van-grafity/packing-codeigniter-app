<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreateByToTransferNoteTable extends Migration
{
    private $table = 'tbltransfernote';

    public function up()
    {
        $fields = [
            'created_by' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'updated_by' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->table, $fields);
        $this->forge->addForeignKey('created_by', 'tblusers', 'id');
        $this->forge->addForeignKey('updated_by', 'tblusers', 'id');
        $this->forge->processIndexes($this->table);
    }

    public function down()
    {
        $this->forge->dropForeignKey($this->table,sprintf('%1$s_created_by_foreign', $this->table));
        $this->forge->dropForeignKey($this->table,sprintf('%1$s_updated_by_foreign', $this->table));
        $this->forge->dropColumn($this->table, ['created_by','updated_by']);
    }
}
