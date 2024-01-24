<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletTransferModel extends Model
{

    protected $table         = 'tblpallettransfer';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = [
        'transaction_number',
        'pallet_id',
        'location_from_id',
        'location_to_id',
        'flag_ready_to_transfer',
        'ready_to_transfer_at',
        'flag_transferred',
        'transferred_at',
        'flag_loaded',
        'loaded_at'
    ];

    public function getPalletTransfer($pallet_transfer_id = null)
    {
        if ($pallet_transfer_id) {
            return $this->where(['id' => $pallet_transfer_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getDatatable()
    {
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
            'tblpallettransfer.transaction_number',
            'pallet.serial_number as pallet_serial_number',
            'location_from.location_name as location_from',
            'location_to.location_name as location_to',
            'SUM(CASE WHEN transfer_note_detail.id IS NOT NULL AND transfer_note_detail.deleted_at IS NULL THEN 1 ELSE 0 END) as total_carton',
            'tblpallettransfer.flag_ready_to_transfer',
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

    public function getTransferNotesByPalletTransfer($pallet_transfer_id)
    {
        $builder = $this->db->table('tblpallettransfer as pallet_transfer');
        $builder->join('tbltransfernote as transfer_note','transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id','left');

        $builder->where('pallet_transfer.id', $pallet_transfer_id);
        $builder->where('transfer_note.deleted_at', null);
        $builder->where('transfer_note_detail.deleted_at', null);
        $builder->groupBy('transfer_note.id');

        $builder->select([
            'transfer_note.id', 
            'transfer_note.serial_number', 
            'transfer_note.issued_by', 
            'transfer_note.authorized_by', 
            'SUM(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN 1 ELSE 0 END) as total_carton', 
            'transfer_note.received_by', 
            'transfer_note.received_at'
        ]);
        
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getLastPalletTransferByPalletID($pallet_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('pallet_id', $pallet_id);
        $builder->where('tblpallettransfer.deleted_at',null);
        $builder->orderBy('created_at','desc');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getLastActivePalletTransferByRackID($rack_id)
    {
        $builder = $this->db->table('tblrackpallet as rack_pallet');
        $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.id = rack_pallet.pallet_transfer_id');
        $builder->where('rack_pallet.rack_id', $rack_id);
        $builder->where('pallet_transfer.deleted_at',null);
        $builder->where('pallet_transfer.flag_loaded','N');
        $builder->orderBy('pallet_transfer.created_at','desc');
        $builder->select('pallet_transfer.*');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function deletePalletTransfer($pallet_transfer_id)
    {
        $transfer_notes = $this->getTransferNotes($pallet_transfer_id);
        
        //## delete transfer note detail
        foreach ($transfer_notes as $key => $transfer_note) {
            $this->deleteTransferNoteDetail($transfer_note->id);
        }
        
        //## delete transfer note
        $TransferNoteModel = model('TransferNoteModel');
        $delete_transfer_note = $TransferNoteModel->where('pallet_transfer_id', $pallet_transfer_id)->delete();
        
        // ## update status pallet to Empty
        $pallet_id = $this->find($pallet_transfer_id)->pallet_id;
        $PalletModel = model('PalletModel');
        $PalletModel->update($pallet_id, ['flag_empty' => 'Y']);

        // ## delete pallet transfer
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

    public function getCartonInPalletTransfer($pallet_transfer_id)
    {
        $TransferNoteModel = model('TransferNoteModel');
        $carton_in_pallet_transfer = [];
        $transfer_note_list = $this->getTransferNotes($pallet_transfer_id);
        foreach ($transfer_note_list as $key => $transfer_note) {

            // ## only need carton that not loaded
            $where_options = [
                'flag_loaded' => 'N'
            ];
            $carton_in_transfer_note = $TransferNoteModel->getCartonInTransferNote($transfer_note->id, $where_options);
            if(!$carton_in_transfer_note) continue;

            foreach ($carton_in_transfer_note as $key_carton => $carton) {
                $carton_in_pallet_transfer[] = $carton;
            }
        }

        return $carton_in_pallet_transfer;
    }

    public function countPalletTransferThisMonth($year_filter = null, $month_filter = null)
    {
        $month_filter = $month_filter ? $month_filter : date('m');
        $year_filter = $year_filter ? $year_filter : date('Y');

        $builder = $this->db->table($this->table);
        $builder->select('count(id) as total_pallet_transfer');
        $builder->where("MONTH(created_at)", $month_filter);
        $builder->where("YEAR(created_at)", $year_filter);
        $result = $builder->get()->getRow();
        return $result->total_pallet_transfer;
    }

    private function deleteTransferNoteDetail($transfer_note_id)
    {
        $builder = $this->db->table('tbltransfernotedetail');
        $builder->where('transfer_note_id', $transfer_note_id);
        $result = $builder->delete();
        return $result;
    }
}
