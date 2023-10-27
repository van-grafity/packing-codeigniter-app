<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonDetailModel extends Model
{
    protected $table            = 'tblcartondetail';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $returnType = 'object';
    protected $allowedFields    = [
        'packinglist_carton_id',
        'product_id',
        'product_qty',
    ];
}
