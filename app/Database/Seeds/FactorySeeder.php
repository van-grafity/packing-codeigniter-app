<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FactorySeeder extends Seeder
{
    private $table = 'tblfactory';

    private const DATA = [
        [
            'id' => 1,
            'name' => 'Factory A',
            'incharge' => 'Incharge 1',
            'remarks' => 'Remarks 1',
        ],
        [
            'id' => 2,
            'name' => 'Factory B',
            'incharge' => 'Incharge 2',
            'remarks' => 'Remarks 2',
        ]
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
