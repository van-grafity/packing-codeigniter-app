<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransferNoteDetailSeeder extends Seeder
{
    private $table = 'tbltransfernotedetail';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'transfer_note_id' => 1,
                'carton_barcode_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'transfer_note_id' => 1,
                'carton_barcode_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'transfer_note_id' => 2,
                'carton_barcode_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
