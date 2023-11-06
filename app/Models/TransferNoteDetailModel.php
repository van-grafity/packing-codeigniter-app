<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferNoteDetailModel extends Model
{

    protected $table         = 'tbltransfernotedetail';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = ['transfer_note_id','carton_barcode_id'];

}
