<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'product_code' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'product_asin_id' => [
                'type' => 'VARCHAR',
                'constraint' => 35,
            ],
            'style' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'product_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'product_category_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_category_id', 'tblcategory', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tblproduct');
    }

    public function down()
    {
        //
    }
}
