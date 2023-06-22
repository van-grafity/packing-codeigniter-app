<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'tblrole';
    protected $useTimestamps = true;
    protected $allowedFields    = [
    ];
    protected $returnType = 'object';

}
