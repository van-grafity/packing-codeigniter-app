<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GL_POSeeder extends Seeder
{
    private $table = 'tblgl_po';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'gl_id' => 1,
                'po_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'gl_id' => 2,
                'po_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
