<?php

namespace App\Models;

use CodeIgniter\Model;

class RackModel extends Model
{

    protected $table         = 'tblrack';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['serial_number','description','flag_empty'];

    public function getRack($rack_id = null)
    {
        if ($rack_id) {
            return $this->where(['id' => $rack_id])->first();
        }
        return $this->db->table('tblrack')->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->select('id, serial_number, description, flag_empty');
        return $builder;
    }

    // public function getRackInformation($rack_id = null)
    // {
    //     // if (!$rack_id) { return false; }

    //     $TransferNoteModel = model('TransferNoteModel');
        

    //     $builder = $this->db->table('tblrack as rack');
    //     $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.rack_id = rack.id');
    //     $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id');
    //     $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = pallet_transfer.id');
    //     $builder->where('rack.id', $rack_id);
    //     // $builder->select('rack.id, rack.serial_number, rack.description, rack.flag_empty');
    //     $builder->select('*');
    //     // $result = $builder->get()->getResult();
    //     // dd($result);
        
    //     return $builder;
    // }

    public function getRackInformation($rack_id = null)
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.rack_id = rack.id','left');
        $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id','left');
        $builder->select('rack.id, rack.serial_number, rack.description, rack.flag_empty, pallet_transfer.id as pallet_transfer_id');
        // $builder->select("IF (rack.flag_empty = 'N','-', 'ADA') AS ");
        // $result = $builder->get()->getResult();
        // $result = $builder->getCompiledSelect();
        // dd($result);
        
        return $builder;
    }
}
