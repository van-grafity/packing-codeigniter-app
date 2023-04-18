<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartonBarcodeSeeder extends Seeder
{
    private $table = 'tblcartonbarcode';

    private const DATA = [
        [
            'id' => 1,
            'carton_pl_id' => 1,
            'carton_no' => 1,
            'carton_barcode' => 99961088754689,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 2,
            'carton_pl_id' => 1,
            'carton_no' => 2,
            'carton_barcode' => 99961088754690,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 3,
            'carton_pl_id' => 1,
            'carton_no' => 3,
            'carton_barcode' => 99961088754691,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 4,
            'carton_pl_id' => 1,
            'carton_no' => 4,
            'carton_barcode' => 99961088754692,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 5,
            'carton_pl_id' => 1,
            'carton_no' => 5,
            'carton_barcode' => 99961088754693,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 6,
            'carton_pl_id' => 1,
            'carton_no' => 6,
            'carton_barcode' => 99961088754694,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 7,
            'carton_pl_id' => 1,
            'carton_no' => 7,
            'carton_barcode' => 99961088754695,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
        [
            'id' => 8,
            'carton_pl_id' => 1,
            'carton_no' => 8,
            'carton_barcode' => 99961088754696,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
