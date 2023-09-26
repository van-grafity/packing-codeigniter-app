<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{

    protected $table         = 'tbllocation';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['location_name','description'];

}
