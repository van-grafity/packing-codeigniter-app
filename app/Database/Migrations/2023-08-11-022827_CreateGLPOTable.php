<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGLPOTable extends Migration
{
    private $table = 'tblgl_po';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'gl_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'po_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'created_at'  => [
                'type' => 'datetime', 
                'null' => true
            ],
            'updated_at'  => [
                'type' => 'datetime', 
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('gl_id', 'tblgl', 'id');
        $this->forge->addForeignKey('po_id', 'tblpurchaseorder', 'id','CASCADE','CASCADE');
        $this->forge->createTable($this->table);


        // ## Restore alter tblpurchaseorder
        $this->forge->dropForeignKey('tblpurchaseorder', 'tblpurchaseorder_gl_id_foreign');
        $this->forge->dropColumn('tblpurchaseorder', ['gl_id']);

    }

    public function down()
    {
        $this->forge->dropForeignKey('tblgl_po', 'tblgl_po_gl_id_foreign');
        $this->forge->dropColumn('tblgl_po', ['gl_id']);
        $this->forge->dropForeignKey('tblgl_po', 'tblgl_po_po_id_foreign');
        $this->forge->dropColumn('tblgl_po', ['po_id']);

        $this->forge->dropTable($this->table);


        // ## Restore alter tblpurchaseorder
        $fields = [
            'gl_id' => [
                'type' => 'bigint', 
                'unsigned' => true,
                'after' => 'po_no',
            ],
        ];
        $this->forge->addColumn('tblpurchaseorder', $fields);
        $this->forge->addForeignKey('gl_id', 'tblgl', 'id');
        $this->forge->processIndexes('tblpurchaseorder');
    }
}
