<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

// class PurchaseOrder extends Migration
// {
//     public function up()
//     {
//         $this->forge->addField([
//             'id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//                 'auto_increment' => true
//             ],
//             'PO_No' => [
//                 'type' => 'VARCHAR',
//                 'constraint' => 35,
//             ],
//             'PL_No' => [
//                 'type' => 'VARCHAR',
//                 'constraint' => 35,
//             ],
//             'gl_id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//             ],
//             'PO_product_id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//             ],
//             'factory_id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//             ],
//             'shipdate' => [
//                 'type' => 'DATE',
//             ],
//             'unit_price' => [
//                 'type' => 'DECIMAL',
//                 'constraint' => '10,2',
//             ],
//             'PO_qty' => [
//                 'type' => 'INT',
//                 'constraint' => 11,
//             ],
//             'PO_amount' => [
//                 'type' => 'INT',
//                 'constraint' => 11,
//             ],
//             'created_at' => [
//                 'type' => 'TIMESTAMP',
//                 'null' => true,
//             ],
//             'updated_at' => [
//                 'type' => 'DATETIME',
//                 'null' => true,
//             ],
//         ]);
//         $this->forge->addKey('id', true);
//         $this->forge->addForeignKey('gl_id', 'tblgl', 'id', 'CASCADE', 'CASCADE');
//         $this->forge->addForeignKey('PO_product_id', 'tblproduct', 'product_id', 'CASCADE', 'CASCADE');
//         $this->forge->addForeignKey('factory_id', 'tblfactory', 'id', 'CASCADE', 'CASCADE');
//         $this->forge->createTable('tblpo');
//     }

//     public function down()
//     {
//         //
//     }
// }


class PurchaseOrderSeeder extends Seeder
{
    private $table = 'tblpo';

    private const DATA = [
        [
            'id' => 1,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 1,
            'factory_id' => 1,
            'shipdate' => '2022-11-03',
            'unit_price' => 10.80,
            'PO_qty' => 10,
            'PO_amount' => 108,
            'created_at' => '2023-04-03 03:01:31',
            'updated_at' => NULL,
        ],
        [
            'id' => 2,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 2,
            'factory_id' => 1,
            'shipdate' => '2022-10-18',
            'unit_price' => 10.80,
            'PO_qty' => 116,
            'PO_amount' => 1253,
            'created_at' => '2023-04-03 03:01:42',
            'updated_at' => NULL,
        ],
        [
            'id' => 3,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 3,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:01:52',
            'updated_at' => NULL,
        ],
        [
            'id' => 4,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 4,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:02',
            'updated_at' => NULL,
        ],
        [
            'id' => 5,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 5,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:12',
            'updated_at' => NULL,
        ],
        [
            'id' => 6,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 6,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:22',
            'updated_at' => NULL,
        ],
        [
            'id' => 7,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 7,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:32',
            'updated_at' => NULL,
        ],
        [
            'id' => 8,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 8,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:42',
            'updated_at' => NULL,
        ],
        [
            'id' => 9,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 9,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:02:52',
            'updated_at' => NULL,
        ],
        [
            'id' => 10,
            'PO_No' => '8X8WFHBM',
            'PL_No' => '8X8WFHBM',
            'gl_id' => 1,
            'PO_product_id' => 10,
            'factory_id' => 1,
            'shipdate' => '2022-10-29',
            'unit_price' => 10.80,
            'PO_qty' => 269,
            'PO_amount' => 2905,
            'created_at' => '2023-04-03 03:03:02',
            'updated_at' => NULL,
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
