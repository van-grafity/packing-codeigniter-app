<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonInspectionModel extends Model
{
    protected $table            = 'tblcartoninspection';
    protected $useTimestamps    = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['carton_barcode_id','opened_by','opened_at','packed_at'];
}
