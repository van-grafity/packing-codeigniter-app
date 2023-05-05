<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeModel extends Model
{
    protected $table            = 'tblsizes';
    protected $allowedFields    = [
        'size'
    ];

    // Dates
    protected $useTimestamps = true;

}
