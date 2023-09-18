<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransferNoteSeeder extends Seeder
{
    private $table = 'tbltransfernote';

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'pallet_transfer_id' => 1,
                'serial_number' => 'PTN-2309-001',
                'issued_by' => "Andi",
                'authorized_by' => "Budi",
                'received_by' => "Candra",
                'received_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'pallet_transfer_id' => 2,
                'serial_number' => 'PTN-2309-002',
                'issued_by' => "Dani",
                'authorized_by' => "Edo",
                'received_by' => "Fandi",
                'received_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table($this->table)->insertBatch($data);
    }
}
