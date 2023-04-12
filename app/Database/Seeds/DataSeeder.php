<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('BuyerSeeder');
        $this->call('CategorySeeder');
        $this->call('FactorySeeder');
        $this->call('ProductSeeder');
        $this->call('PurchaseOrderSeeder');
        $this->call('PurchaseOrderDetailSeeder');
        $this->call('EmployeeSeeder');
        $this->call('UserSeeder');
    }
}
