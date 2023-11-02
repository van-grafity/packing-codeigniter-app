<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
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
        $this->call('GL_POSeeder');
        $this->call('PackingListSeeder');
        $this->call('PackinglistCartonSeeder');
        $this->call('CartonDetailSeeder');
        $this->call('CartonBarcodeSeeder');
        $this->call('LocationSeeder');
        $this->call('PalletSeeder');
        $this->call('RackSeeder');
        $this->call('PalletTransferSeeder');
        $this->call('TransferNoteSeeder');
        $this->call('TransferNoteDetailSeeder');
    }
}
