<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonLoadingModel extends Model
{

    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'packinglist_id',
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
        'flag_packed',
        'packed_at',
        'flag_loaded',
        'loaded_at',
    ];

    public function getData($carton_barcode_id = null)
    {
        if ($carton_barcode_id) {
            return $this->where(['id' => $carton_barcode_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getDatatable()
    {
        $builder = $this->db->table($this->table);
        
        // ## Join tabel dengan alias
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = tblcartonbarcode.packinglist_carton_id');
        $builder->join('tblpackinglist as packinglist', 'packinglist.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblsyncpurchaseorder as sync_po', 'sync_po.purchase_order_id = po.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.carton_barcode_id = tblcartonbarcode.id');
        $builder->where('tblcartonbarcode.flag_packed', 'Y');
        

        // ## Memilih kolom dengan alias
        $builder->select([
            'tblcartonbarcode.id', 
            'tblcartonbarcode.barcode', 
            'tblcartonbarcode.flag_packed', 
            'tblcartonbarcode.flag_loaded', 
            'sync_po.buyer_name', 
            'po.po_no as po_number', 
            'sync_po.gl_number', 
        ]);
        
        return $builder;
    }
}
