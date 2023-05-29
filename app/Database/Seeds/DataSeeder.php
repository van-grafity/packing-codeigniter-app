<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('BuyerSeeder');
        $this->call('StyleSeeder');
        $this->call('FactorySeeder');
        $this->call('SizeSeeder');
        $this->call('ColourSeeder');
        $this->call('CategorySeeder');
        $this->call('GLSeeder');
        $this->call('ProductSeeder');
        $this->call('PurchaseOrderSeeder');
        $this->call('PurchaseOrderDetailSeeder');
        $this->call('PackingListSeeder');
        // $this->call('CartonBarcodeSeeder');
        // $this->call('CartonRatioSeeder');
    }
}
