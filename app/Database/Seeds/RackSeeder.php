<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RackSeeder extends Seeder
{
    private $table = 'tblrack';

    public function run()
    {
        $count_id = 1;
        $data_racks = [];
        $rack_level = 1; // ## start from level 1
        $counter_rack_per_level = 1; // ## for couting qty per level, if meet maximum then add level

        $code_rack_per_type[0] = ['A','B'];
        $code_rack_per_type[1] = ['C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S'];
        $code_rack_per_type[2] = ['T'];
        $code_rack_per_type[3] = ['U'];
        
        $total_rack_per_type[0] = 60; // ## Rack A dan B
        $total_rack_per_type[1] = 66; // ## Rack C sampai S
        $total_rack_per_type[2] = 78; // ## Rack T
        $total_rack_per_type[3] = 48; // ## Rack U

        $qty_per_level_per_type[0] = 20;
        $qty_per_level_per_type[1] = 22;
        $qty_per_level_per_type[2] = 26;
        $qty_per_level_per_type[3] = 16;


        foreach ($code_rack_per_type as $key_type => $code_rack_list) {
            foreach ($code_rack_list as $key_rack => $code_rack) {

                $total_rack = $total_rack_per_type[$key_type];
                $max_qty_this_level = $qty_per_level_per_type[$key_type];
                $current_level = 1;
                $counter_rack_per_level = 1;
                
                for ($i=0; $i < $total_rack; $i++) {
                    $serial_code = 'RCK-'.$code_rack;
                    $rack_id = str_pad($i+1, 3, '0', STR_PAD_LEFT);
                    $rack_id = $serial_code . $rack_id;

                    if($counter_rack_per_level <= $max_qty_this_level){
                        $current_level = $current_level;
                    } else {
                        $current_level++;
                        $counter_rack_per_level = 1; // ## reset counter to 1 each next level
                    }

                    
                    $rack = [
                        'id' => $count_id,
                        'serial_number' => $rack_id,
                        'area' => $code_rack,
                        'level' => $current_level,
                        'description' => $rack_id . ' ada di area ' . $code_rack . ' dengan level ' . $current_level,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $data_racks[] = $rack;
                    $count_id++;
                    $counter_rack_per_level++;
                }
            }
        }
        $this->db->table($this->table)->insertBatch($data_racks);
    }
}
