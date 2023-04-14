<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('EmployeeSeeder');
        $this->call('UserSeeder');
        $this->call('BuyerSeeder');
        $this->call('GLSeeder');
        $this->call('CategorySeeder');
        $this->call('FactorySeeder');
        $this->call('ProductSeeder');
        $this->call('PurchaseOrderSeeder');
    }
}
