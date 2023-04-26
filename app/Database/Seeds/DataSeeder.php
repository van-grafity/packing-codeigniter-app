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
        $this->call('StyleSeeder');
        $this->call('ProductSeeder');
        $this->call('FactorySeeder');
        $this->call('PurchaseOrderSeeder');
        $this->call('PurchaseOrderDetailSeeder');
        $this->call('PackingListSeeder');
        $this->call('SizeSeeder');
        $this->call('CartonBarcodeSeeder');
        $this->call('CartonRatioSeeder');
        $this->call('PackingListSizeSeeder');
    }
}
