<?php

namespace App\Models;

use CodeIgniter\Model;

class PalletReceiveModel extends Model
{

    protected $table         = 'tblpallettransfer';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['pallet_id','location_from_id','location_to_id','flag_transferred','flag_loaded'];

    public function getData($pallet_transfer_id = null)
    {
        if ($pallet_transfer_id) {
            return $this->where(['id' => $pallet_transfer_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this;
        
        // ## Join tabel dengan alias
        $builder->join('tblpallet as pallet', 'pallet.id = tblpallettransfer.pallet_id');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = tblpallettransfer.id','left');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id','left');
        $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.pallet_transfer_id = tblpallettransfer.id','left');
        $builder->join('tblrack as rack', 'rack.id = rack_pallet.rack_id','left');
        $builder->join('tbllocation as location_from','location_from.id = tblpallettransfer.location_from_id');
        $builder->join('tbllocation as location_to','location_to.id = tblpallettransfer.location_to_id');
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
            'tblpallettransfer.flag_loaded',
            'rack.serial_number as rack_serial_number'
        ]);

        // ## Mengelompokkan berdasarkan pallet transfer id dan rack. harus dua dua nya biar karena type sql nya full group
        $builder->groupBy('tblpallettransfer.id, rack.serial_number');
        
        return $builder;
    }

    public function getPalletLocation($pallet_transfer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.pallet_transfer_id = tblpallettransfer.id','left');
        $builder->join('tblrack as rack', 'rack.id = rack_pallet.rack_id','left');
        $builder->where('tblpallettransfer.flag_transferred','Y');
        $builder->where('tblpallettransfer.flag_loaded','N');
        $builder->where('tblpallettransfer.id', $pallet_transfer_id);
        $builder->where('rack_pallet.out_date', null);
        $builder->select('rack.serial_number');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getPalletTransferByPalletNumber($pallet_serial_number)
    {
        $builder = $this->db->table('tblpallet as pallet');
        $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.pallet_id = pallet.id');
        $builder->join('tbllocation as location_from','location_from.id = pallet_transfer.location_from_id');
        $builder->join('tbllocation as location_to','location_to.id = pallet_transfer.location_to_id');
        $builder->join('tbltransfernote as transfer_note','transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id');

        $builder->where(['pallet_transfer.flag_ready_to_transfer' => 'Y']);
        $builder->where(['pallet_transfer.flag_loaded' => 'N']);
        $builder->where(['pallet.serial_number' => $pallet_serial_number]);
        $builder->orderBy('pallet_transfer.created_at','DESC');
        $builder->groupBy('pallet_transfer.id');

        $builder->select('
            pallet.id as pallet_id, 
            pallet.serial_number as pallet_number, 
            pallet.flag_empty, 
            location_from.location_name as location_from, 
            location_to.location_name as location_to, 
            pallet_transfer.id as pallet_transfer_id, 
            pallet_transfer.transaction_number, 
            pallet_transfer.flag_ready_to_transfer, 
            pallet_transfer.flag_transferred, 
            pallet_transfer.flag_loaded, 
            COUNT(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN transfer_note_detail.id END) as total_carton
        ');
        $result = $builder->get()->getRow();
        
        return $result;
    }
}
