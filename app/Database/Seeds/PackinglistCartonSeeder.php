<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackinglistCartonSeeder extends Seeder
{
    private $table = 'tblpackinglistcarton';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'packinglist_id' => 1,
                'carton_qty' => 1,
                'gross_weight' => 5.33,
                'net_weight' => 4.68,
                'carton_number_from' => 1,
                'carton_number_to' => 1,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'packinglist_id' => 1,
                'carton_qty' => 5,
                'gross_weight' => 11.21,
                'net_weight' => 9.92,
                'carton_number_from' => 1,
                'carton_number_to' => 5,
                'measurement_ctn' => '60L x 38W x 28H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'packinglist_id' => 1,
                'carton_qty' => 1,
                'gross_weight' => 8.97,
                'net_weight' => 7.94,
                'carton_number_from' => 6,
                'carton_number_to' => 6,
                'measurement_ctn' => '60L x 38W x 22H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'packinglist_id' => 1,
                'carton_qty' => 13,
                'gross_weight' => 11.77,
                'net_weight' => 10.48,
                'carton_number_from' => 1,
                'carton_number_to' => 13,
                'measurement_ctn' => '60L x 38W x 28H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'packinglist_id' => 1,
                'carton_qty' => 1,
                'gross_weight' => 5.3,
                'net_weight' => 4.72,
                'carton_number_from' => 14,
                'carton_number_to' => 14,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'packinglist_id' => 2,
                'carton_qty' => 91,
                'gross_weight' => 3.29,
                'net_weight' => 2.77,
                'carton_number_from' => 1,
                'carton_number_to' => 91,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'packinglist_id' => 2,
                'carton_qty' => 94,
                'gross_weight' => 3.29,
                'net_weight' => 2.77,
                'carton_number_from' => 92,
                'carton_number_to' => 185,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 8,
                'packinglist_id' => 2,
                'carton_qty' => 101,
                'gross_weight' => 2.57,
                'net_weight' => 2.15,
                'carton_number_from' => 186,
                'carton_number_to' => 286,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 9,
                'packinglist_id' => 2,
                'carton_qty' => 110,
                'gross_weight' =>2.57,
                'net_weight' => 2.15,
                'carton_number_from' => 287,
                'carton_number_to' => 396,
                'measurement_ctn' => '60L x 38W x 14H',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
