<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletTransferModel extends Model
{

    protected $table         = 'tblpallettransfer';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = ['pallet_id','location_from_id','location_to_id','flag_transferred','flag_loaded'];

    public function getPalletTransfer($pallet_transfer_id = null)
    {
        if ($pallet_transfer_id) {
            return $this->where(['id' => $pallet_transfer_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getDatatable()
    {
        // !! dont forget to delete this in the future
        // $builder = $this->db->table('tblpallettransfer');
        // $builder->join('tblpallet as pallet', 'pallet.id = tblpallettransfer.pallet_id');
        // $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = tblpallettransfer.id','left');
        // $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id','left');
        // $builder->join('tbllocation as location_from','location_from.id = tblpallettransfer.location_from_id');
        // $builder->join('tbllocation as location_to','location_to.id = tblpallettransfer.location_to_id');
        // // $builder->where('transfer_note.deleted_at', null);
        // $builder->groupBy('tblpallettransfer.id');
        // $builder->select('tblpallettransfer.id, pallet.serial_number as pallet_serial_number, location_from.location_name as location_from, location_to.location_name as location_to, 
        //     (SELECT count(tbltransfernotedetail.id) FROM `tbltransfernotedetail` 
        //     JOIN tbltransfernote on tbltransfernote.id = tbltransfernotedetail.transfer_note_id 
        //     JOIN tblpallettransfer as pallet_transfer_sub on pallet_transfer_sub.id = tbltransfernote.pallet_transfer_id 
        //     WHERE pallet_transfer_sub.id = tblpallettransfer.id
        //     AND tbltransfernote.deleted_at IS NULL ) as total_carton, 
        // tblpallettransfer.flag_transferred, tblpallettransfer.flag_loaded');
        // return $builder;

        $builder = $this->db->table('tblpallettransfer');
    
        // ## Join tabel dengan alias
        $builder->join('tblpallet as pallet', 'pallet.id = tblpallettransfer.pallet_id');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = tblpallettransfer.id', 'left');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id', 'left');
        $builder->join('tbllocation as location_from', 'location_from.id = tblpallettransfer.location_from_id');
        $builder->join('tbllocation as location_to', 'location_to.id = tblpallettransfer.location_to_id');
        $builder->where('tblpallettransfer.deleted_at',null);
        
        // ## Memilih kolom dengan alias
        $builder->select([
            'tblpallettransfer.id',
            'pallet.serial_number as pallet_serial_number',
            'location_from.location_name as location_from',
            'location_to.location_name as location_to',
            'SUM(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN 1 ELSE 0 END) as total_carton',
            'tblpallettransfer.flag_transferred',
            'tblpallettransfer.flag_loaded'
        ]);
        
        // ## Mengelompokkan berdasarkan id
        $builder->groupBy('tblpallettransfer.id');
        
        return $builder;
    }

    public function getData($pallet_transfer_id = null)
    {
        $builder = $this->getDatatable();
        if($pallet_transfer_id){
            $builder->select('tblpallettransfer.pallet_id');
            $builder->where('tblpallettransfer.id',$pallet_transfer_id);
            $result = $builder->get()->getRow();
            return $result;
        }
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getDetailPalletBySerialNumber($pallet_serial_number)
    {
        $builder = $this->db->table('tblpallet as pallet');
        $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.pallet_id = pallet.id','left');
        $builder->join('tbllocation as location_from','location_from.id = pallet_transfer.location_from_id','left');
        $builder->join('tbllocation as location_to','location_to.id = pallet_transfer.location_to_id','left');

        $builder->where(['pallet.serial_number' => $pallet_serial_number]);
        $builder->select('pallet.id as pallet_id, pallet.serial_number as pallet_number, pallet.flag_empty, location_from.location_name as location_from, location_to.location_name as location_to, pallet_transfer.id as pallet_transfer_id, pallet_transfer.flag_transferred, pallet_transfer.flag_loaded');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getTransferNotesInPallet($pallet_id)
    {
        $builder = $this->db->table('tblpallet as pallet');
        $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.pallet_id = pallet.id');
        $builder->join('tbltransfernote as transfer_note','transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id','left');
        $builder->where(['pallet.id' => $pallet_id]);
        $builder->where('transfer_note.deleted_at', null);
        $builder->groupBy('transfer_note.id');
        $builder->select('transfer_note.id, transfer_note.serial_number, transfer_note.issued_by, transfer_note.authorized_by, 
        SUM(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN 1 ELSE 0 END) as total_carton, 
        transfer_note.received_by, transfer_note.received_at');
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getLastPalletTransferByPalletID($pallet_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('pallet_id', $pallet_id);
        $builder->orderBy('created_at','desc');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function deletePalletTransfer($pallet_transfer_id)
    {
        $transfer_notes = $this->getTransferNotes($pallet_transfer_id);
        
        //## delete transfer note detail
        foreach ($transfer_notes as $key => $transfer_note) {
            $this->delteTransferNoteDetail($transfer_note->id);
        }
        
        //## delete transfer note
        $TransferNoteModel = model('TransferNoteModel');
        $delete_transfer_note = $TransferNoteModel->where('pallet_transfer_id', $pallet_transfer_id)->delete();
        
        $PalletTransferModel = model('PalletTransferModel');
        $delete_pallet_transfer = $PalletTransferModel->where('id', $pallet_transfer_id)->delete();
    }

    public function getTransferNotes($pallet_transfer_id)
    {
        $builder = $this->db->table('tbltransfernote');
        $builder->where('pallet_transfer_id', $pallet_transfer_id);
        $builder->where('tbltransfernote.deleted_at', null);
        $result = $builder->get()->getResult();
        return $result;
    }

    public function isTransferred($pallet_transfer_id)
    {
        $builder = $this->db->table('tblpallettransfer');
        $builder->where('id', $pallet_transfer_id);
        $result = $builder->get()->getRow();
        $is_transferred = $result->flag_transferred == 'Y' ? true : false;
        return $is_transferred;
    }

    private function delteTransferNoteDetail($transfer_note_id)
    {
        $builder = $this->db->table('tbltransfernotedetail');
        $builder->where('transfer_note_id', $transfer_note_id);
        $result = $builder->delete();
        return $result;
    }
}
