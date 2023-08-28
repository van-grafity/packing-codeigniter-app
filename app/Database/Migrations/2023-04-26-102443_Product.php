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
                'null' => true,
            ],
            'product_category_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_style_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_colour_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_size_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
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
        $this->forge->addForeignKey('product_category_id', 'tblcategory', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('product_style_id', 'tblstyle', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('product_colour_id', 'tblcolour', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('product_size_id', 'tblsize', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tblproduct');
    }

    public function down()
    {
        $this->forge->dropTable('tblproduct');
    }
}
