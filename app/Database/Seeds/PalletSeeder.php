<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PalletSeeder extends Seeder
{
    private $table = 'tblpallet';

    public function run()
    {
        $total_pallet_a = 1750;
        $total_pallet_b = 850;
        $count_id = 1;

        $data_pallets = [];
        for ($i=0; $i < $total_pallet_a; $i++) {
            $serial_code = 'PLT-A';
            $pallet_id = str_pad($i+1, 4, '0', STR_PAD_LEFT);
            $pallet_id = $serial_code . $pallet_id;
            
            $pallet = [
                'id' => $count_id,
                'serial_number' => $pallet_id,
                'description' => 'Pallet A',
                'flag_empty' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $data_pallets[] = $pallet;
            $count_id++;
        }

        for ($i=0; $i < $total_pallet_b; $i++) {
            $serial_code = 'PLT-B';
            $pallet_id = str_pad($i+1, 4, '0', STR_PAD_LEFT);
            $pallet_id = $serial_code . $pallet_id;
            
            $pallet = [
                'id' => $count_id,
                'serial_number' => $pallet_id,
                'description' => 'Pallet B',
                'flag_empty' => 'Y',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $data_pallets[] = $pallet;
            $count_id++;
        }

        $this->db->table($this->table)->insertBatch($data_pallets);
    }
}
