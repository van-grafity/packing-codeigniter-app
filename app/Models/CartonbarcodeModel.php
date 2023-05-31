<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonBarcodeModel extends Model
{
    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
    ];
}
