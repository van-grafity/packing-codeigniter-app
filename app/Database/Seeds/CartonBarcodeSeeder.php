<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonBarcodeSeeder extends Seeder
{
    private $table = 'tblcartonbarcode';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'packinglist_id' => 1,
                'packinglist_carton_id' => 1,
                'carton_number_by_system' => 1,
                'carton_number_by_input' => 1,
                'barcode' => '99961088754689',
                'flag_packed' => 'N',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'packinglist_id' => 1,
                'packinglist_carton_id' => 1,
                'carton_number_by_system' => 2,
                'carton_number_by_input' => 2,
                'barcode' => '99961088754690',
                'flag_packed' => 'N',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'packinglist_id' => 1,
                'packinglist_carton_id' => 1,
                'carton_number_by_system' => 3,
                'carton_number_by_input' => 3,
                'barcode' => '99961088754690',
                'flag_packed' => 'N',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
