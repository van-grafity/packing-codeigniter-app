<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletTransferModel extends Model
{

    protected $table         = 'tblpallettransfer';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
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
        $builder = $this->db->table($this->table);
        $builder->join('tblpallet as pallet', 'pallet.id = tblpallettransfer.pallet_id');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = tblpallettransfer.id','left');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id','left');
        $builder->join('tbllocation as location_from','location_from.id = tblpallettransfer.location_from_id');
        $builder->join('tbllocation as location_to','location_to.id = tblpallettransfer.location_to_id');
        $builder->groupBy('tblpallettransfer.id');
        $builder->select('tblpallettransfer.id, pallet.serial_number as pallet_serial_number, location_from.location_name as location_from, location_to.location_name as location_to, count(transfer_note_detail.id) as total_carton, tblpallettransfer.flag_transferred, tblpallettransfer.flag_loaded');
        return $builder;
    }

    public function getData($pallet_transfer_id = null)
    {

        $builder = $this->getDatatable();
        if($pallet_transfer_id){
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
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->where(['pallet.id' => $pallet_id]);
        $builder->groupBy('transfer_note.id');
        $builder->select('transfer_note.id, transfer_note.serial_number, transfer_note.issued_by, transfer_note.authorized_by, count(transfer_note_detail.id) as total_carton, transfer_note.received_by, transfer_note.received_at');
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
        
        // //## delete transfer note detail
        foreach ($transfer_notes as $key => $transfer_note) {
            $this->delteTransferNoteDetail($transfer_note->id);
        }
        
        // //## delete transfer note
        $TransferNoteModel = model('TransferNoteModel');
        $delete_transfer_note = $TransferNoteModel->where('pallet_transfer_id', $pallet_transfer_id)->delete();
        
        
        $PalletTransferModel = model('PalletTransferModel');
        $delete_pallet_transfer = $PalletTransferModel->where('id', $pallet_transfer_id)->delete();
    }

    private function getTransferNotes($pallet_transfer_id)
    {
        $builder = $this->db->table('tbltransfernote');
        $builder->where('pallet_transfer_id', $pallet_transfer_id);
        $result = $builder->get()->getResult();
        return $result;
    }

    private function delteTransferNoteDetail($transfer_note_id)
    {
        $builder = $this->db->table('tbltransfernotedetail');
        $builder->where('transfer_note_id', $transfer_note_id);
        $result = $builder->delete();
        return $result;
    }
}
