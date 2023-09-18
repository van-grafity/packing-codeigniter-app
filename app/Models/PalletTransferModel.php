<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletTransferModel extends Model
{

    protected $table         = 'tblpallettransfer';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['pallet_id','location_from_id','location_to_id','flag_transfered','flag_loaded'];

    public function getPalletTransfer($pallet_transfer_id = null)
    {
        if ($pallet_transfer_id) {
            return $this->where(['id' => $pallet_transfer_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this->db->table($this->table);
        $builder->join('tblpallet as pallet', 'pallet.id = tblpallettransfer.pallet_id');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = tblpallettransfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tbllocation as location_from','location_from.id = tblpallettransfer.location_from_id');
        $builder->join('tbllocation as location_to','location_to.id = tblpallettransfer.location_to_id');
        $builder->groupBy('tblpallettransfer.id');
        $builder->select('tblpallettransfer.id, pallet.serial_number as pallet_serial_number, location_from.location_name as location_from, location_to.location_name as location_to, sum(transfer_note_detail.id) as total_carton, tblpallettransfer.flag_transferred, tblpallettransfer.flag_loaded');
        return $builder;
    }
}
