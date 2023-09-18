<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferNoteModel extends Model
{

    protected $table         = 'tbltransfernote';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['pallet_transfer_id','serial_number','issued_by','authorized_by','received_by','received_at'];

    public function getTransferNote($transfer_note_id = null)
    {
        if ($transfer_note_id) {
            return $this->where(['id' => $transfer_note_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

}
