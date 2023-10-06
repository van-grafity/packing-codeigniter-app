<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RackSeeder extends Seeder
{
    private $table = 'tblrack';

    public function run()
    {
        $total_rack_a = 20;
        $total_rack_b = 20;
        $count_id = 1;

        $data_racks = [];
        for ($i=0; $i < $total_rack_a; $i++) {
            $serial_code = 'RCK-A';
            $rack_id = str_pad($i+1, 3, '0', STR_PAD_LEFT);
            $rack_id = $serial_code . $rack_id;
            
            $rack = [
                'id' => $count_id,
                'serial_number' => $rack_id,
                'description' => 'Level 1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $data_racks[] = $rack;
            $count_id++;
        }

        for ($i=0; $i < $total_rack_b; $i++) {
            $serial_code = 'RCK-B';
            $rack_id = str_pad($i+1, 3, '0', STR_PAD_LEFT);
            $rack_id = $serial_code . $rack_id;
            
            $rack = [
                'id' => $count_id,
                'serial_number' => $rack_id,
                'description' => 'Level 2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $data_racks[] = $rack;
            $count_id++;
        }

        $this->db->table($this->table)->insertBatch($data_racks);
    }
}
