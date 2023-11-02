<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocationSeeder extends Seeder
{
    private $table = 'tbllocation';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'location_name' => 'Factory A',
                'description' => 'Factory Building A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'location_name' => 'Factory B',
                'description' => 'Factory Building B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'location_name' => 'FG Warehouse',
                'description' => 'Finish Good Warehouse. Building C',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
