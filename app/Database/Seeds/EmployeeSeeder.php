<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    private $table = 'employees';

    private const DATA = [
        [
        'id' => 1,
        'nama_karyawan' => 'Budi',
        'usia' => 20,
        'status_vaksin_1' => 'belum',
        'status_vaksin_2' => 'belum',
        ],
        [
            'id' => 2,
            'nama_karyawan' => 'Susi',
            'usia' => 25,
            'status_vaksin_1' => 'belum',
            'status_vaksin_2' => 'belum',
        ],
        [
            'id' => 3,
            'nama_karyawan' => 'Rudi',
            'usia' => 30,
            'status_vaksin_1' => 'belum',
            'status_vaksin_2' => 'belum',
        ],
        [
            'id' => 4,
            'nama_karyawan' => 'Susi',
            'usia' => 35,
            'status_vaksin_1' => 'belum',
            'status_vaksin_2' => 'belum',
        ],
        [
            'id' => 5,
            'nama_karyawan' => 'Rudi',
            'usia' => 40,
            'status_vaksin_1' => 'belum',
            'status_vaksin_2' => 'belum',
        ],
        [
            'id' => 6,
            'nama_karyawan' => 'Susi',
            'usia' => 45,
            'status_vaksin_1' => 'belum',
            'status_vaksin_2' => 'belum',
        ]
    ];
            
    public function run()
    {
        $this->db->table($this->table)->insertBatch(self::DATA);
    }
}
