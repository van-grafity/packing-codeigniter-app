<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FactorySeeder extends Seeder
{
    private $table = 'tblfactory';

    private const DATA = [
        [
            'id' => 1,
            'name' => 'Factory 1',
            'incharge' => 'Incharge 1',
            'remarks' => 'Remarks 1',
        ],
        [
            'id' => 2,
            'name' => 'Factory 2',
            'incharge' => 'Incharge 2',
            'remarks' => 'Remarks 2',
        ],
        [
            'id' => 3,
            'name' => 'Factory 3',
            'incharge' => 'Incharge 3',
            'remarks' => 'Remarks 3',
        ],
        [
            'id' => 4,
            'name' => 'Factory 4',
            'incharge' => 'Incharge 4',
            'remarks' => 'Remarks 4',
        ],
        [
            'id' => 5,
            'name' => 'Factory 5',
            'incharge' => 'Incharge 5',
            'remarks' => 'Remarks 5',
        ],
        [
            'id' => 6,
            'name' => 'Factory 6',
            'incharge' => 'Incharge 6',
            'remarks' => 'Remarks 6',
        ],
        [
            'id' => 7,
            'name' => 'Factory 7',
            'incharge' => 'Incharge 7',
            'remarks' => 'Remarks 7',
        ],
        [
            'id' => 8,
            'name' => 'Factory 8',
            'incharge' => 'Incharge 8',
            'remarks' => 'Remarks 8',
        ],
        [
            'id' => 9,
            'name' => 'Factory 9',
            'incharge' => 'Incharge 9',
            'remarks' => 'Remarks 9',
        ],
        [
            'id' => 10,
            'name' => 'Factory 10',
            'incharge' => 'Incharge 10',
            'remarks' => 'Remarks 10',
        ],
        [
            'id' => 11,
            'name' => 'Factory 11',
            'incharge' => 'Incharge 11',
            'remarks' => 'Remarks 11',
        ],
        [
            'id' => 12,
            'name' => 'Factory 12',
            'incharge' => 'Incharge 12',
            'remarks' => 'Remarks 12',
        ],
        [
            'id' => 13,
            'name' => 'Factory 13',
            'incharge' => 'Incharge 13',
            'remarks' => 'Remarks 13',
        ],
        [
            'id' => 14,
            'name' => 'Factory 14',
            'incharge' => 'Incharge 14',
            'remarks' => 'Remarks 14',
        ],
    ];

    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
