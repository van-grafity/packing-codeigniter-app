<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonInspectionModel extends Model
{
    protected $table            = 'tblcartoninspection';
    protected $useTimestamps    = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['issued_by','received_by','received_date'];
}
