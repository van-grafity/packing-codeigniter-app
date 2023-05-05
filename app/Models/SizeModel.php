<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeModel extends Model
{
    protected $table            = 'tblsizes';
    protected $allowedFields    = [
        'size'
    ];
    protected $returnType = 'object';

    // Dates
    protected $useTimestamps = true;

}
