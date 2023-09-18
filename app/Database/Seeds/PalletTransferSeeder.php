<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PalletTransferSeeder extends Seeder
{
    private $table = 'tblpallettransfer';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'pallet_id' => 1,
                'location_from_id' => 1,
                'location_to_id' => 3,
                'flag_transferred' => 'N',
                'flag_loaded' => 'N',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'pallet_id' => 1751,
                'location_from_id' => 2,
                'location_to_id' => 3,
                'flag_transferred' => 'N',
                'flag_loaded' => 'N',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
