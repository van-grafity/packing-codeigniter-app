<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartonDetail extends Migration
{
    private $table = 'tblcartondetail';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'packinglist_carton_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'bigint',
                'unsigned' => true,
            ],
            'product_qty' => [
                'type' => 'int',
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
        $this->forge->addForeignKey('packinglist_carton_id', 'tblpackinglistcarton', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('product_id', 'tblproduct', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
