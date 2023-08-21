<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonInspectionDetailModel extends Model
{
    protected $table            = 'tblcartoninspectiondetail';
    protected $useTimestamps    = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['carton_inspection_id','carton_barcode_id'];
}
