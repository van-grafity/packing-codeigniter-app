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
            'carton_pl_id' => 2,
            'carton_no' => 2,
            'carton_barcode' => 99961088754690,
            'created_at' => '2023-04-17 21:50:01',
            'updated_at' => '2023-04-17 21:50:01',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
