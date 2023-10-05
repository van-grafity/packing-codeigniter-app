<?php

namespace App\Models;

use CodeIgniter\Model;

class RackPalletModel extends Model
{

    protected $table         = 'tblrackpallet';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['rack_id','pallet_transfer_id','entry_date','out_date'];

}
