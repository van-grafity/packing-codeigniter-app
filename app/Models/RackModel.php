<?php

namespace App\Models;

use CodeIgniter\Model;

class RackModel extends Model
{

    protected $table         = 'tblrack';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $allowedFields = ['serial_number','area','level','description','flag_empty'];

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
        $builder->select('id, serial_number, description, area, level, flag_empty');
        return $builder;
    }

    public function getRackInformation()
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.rack_id = rack.id','left');
        $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id','left');
        $builder->join('tblpallet as pallet', 'pallet.id = pallet_transfer.pallet_id','left');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = pallet_transfer.id','left');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id','left');
        $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.id = transfer_note_detail.carton_barcode_id','left');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id','left');
        $builder->join('tblpackinglist as pl', 'pl.id = pl_carton.packinglist_id','left');
        $builder->join('tblpurchaseorder as po', 'po.id = pl.packinglist_po_id','left');
        $builder->join('tblsyncpurchaseorder as sync_po', 'sync_po.purchase_order_id = po.id','left');
        $builder->groupBy('rack.id');
        
        $builder->select([
            'rack.id', 
            'rack.serial_number', 
            'sync_po.gl_number',
            'po.po_no',
            'sync_po.buyer_name',
            'rack.flag_empty', 
            'pallet_transfer.id as pallet_transfer_id',
            'pallet.serial_number as pallet_serial_number',
            'rack.level',
        ]);

        // $result = $builder->get()->getResult();
        // dd($result);
        
        return $builder;
    }

    public function getRackInformation_array($params)
    {
        $builder = $this;
        $builder->select('tblrack.id, tblrack.serial_number, tblrack.level, tblrack.flag_empty');
        $rack_list = $builder->paginate($params['length'], 'default',$params['start']);
        
        $pager = $builder->pager;

        foreach ($rack_list as $key_rack => $rack) {
            $pallet_transfer = $this->getPalletTransferInRack($rack->id);
            
            if($pallet_transfer){
                $gl_information = $this->getGlInformation($pallet_transfer->id);
                $rack->gl_number = $gl_information->gl_number; 
                $rack->buyer_name = $gl_information->buyer_name; 
                $rack->po_no = $gl_information->po_no; 
                
                $product_information = $this->getProductInformation($pallet_transfer->id);
                $rack->colour = $product_information->colour; 
                
                $carton_information = $this->getCartonInformation($pallet_transfer->id);
                $rack->total_carton = $carton_information->total_carton; 
                $rack->total_pcs = $carton_information->total_pcs;

                $rack->transfer_note = $this->getTransferNoteList($pallet_transfer->id);

                
                $rack->pallet_serial_number = $pallet_transfer->serial_number; 
            } else {
                $rack->gl_number = '-'; 
                $rack->buyer_name = '-'; 
                $rack->po_no = '-'; 
                $rack->colour = '-'; 
                $rack->total_carton = '-'; 
                $rack->total_pcs = '-'; 
                $rack->pallet_serial_number = '-'; 
                $rack->transfer_note = '-';
            }
        }
        $result = [
            'rack_list' => $rack_list,
            'pager' => $pager,
        ];
        return $result;
    }

    public function getRackLocationSheet_array($params)
    {
        $filter_rack_area = $params['filter_rack_area'];
        $filter_rack_level = $params['filter_rack_level'];
        
        $builder = $this;
        if($filter_rack_area){
            $builder->where('tblrack.area',$filter_rack_area);
        } else {
            $builder->where('tblrack.area',null);
        }

        if($filter_rack_level){
            $builder->where('tblrack.level',$filter_rack_level);
        }

        $builder->select('tblrack.id, tblrack.serial_number, tblrack.level, tblrack.flag_empty');
        $rack_list = $builder->paginate($params['length'], 'default',$params['start']);

        $pager = $builder->pager;

        foreach ($rack_list as $key_rack => $rack) {
            $pallet_transfer = $this->getPalletTransferInRack($rack->id);
            
            if($pallet_transfer){
                $gl_information = $this->getGlInformation($pallet_transfer->id);
                $rack->gl_number = $gl_information->gl_number; 
                $rack->buyer_name = $gl_information->buyer_name; 
                $rack->po_no = $gl_information->po_no; 
                
                $product_information = $this->getProductInformation($pallet_transfer->id);
                $rack->colour = $product_information->colour; 
                
                $carton_information = $this->getCartonInformation($pallet_transfer->id);
                $rack->total_carton = $carton_information->total_carton; 
                $rack->total_pcs = $carton_information->total_pcs;

                $rack->transfer_note = $this->getTransferNoteList($pallet_transfer->id);

                
                $rack->pallet_serial_number = $pallet_transfer->serial_number; 
            } else {
                $rack->gl_number = '-'; 
                $rack->buyer_name = '-'; 
                $rack->po_no = '-'; 
                $rack->colour = '-'; 
                $rack->total_carton = '-'; 
                $rack->total_pcs = '-'; 
                $rack->pallet_serial_number = '-'; 
                $rack->transfer_note = '-';
            }
        }
        $result = [
            'rack_list' => $rack_list,
            'pager' => $pager,
        ];
        return $result;
    }

    public function getRackLocationSheet_pdf($params)
    {
        $filter_rack_area = $params['filter_rack_area'];
        $filter_rack_level = $params['filter_rack_level'];
        
        $builder = $this;
        if($filter_rack_area){
            $builder->where('tblrack.area',$filter_rack_area);
        } else {
            $builder->where('tblrack.area',null);
        }

        if($filter_rack_level){
            $builder->where('tblrack.level',$filter_rack_level);
        }

        $builder->select('tblrack.id, tblrack.serial_number, tblrack.level, tblrack.flag_empty');
        $rack_list = $builder->get()->getResult();
        
        
        foreach ($rack_list as $key_rack => $rack) {
            $pallet_transfer = $this->getPalletTransferInRack($rack->id);
            
            if($pallet_transfer){
                $gl_information = $this->getGlInformation($pallet_transfer->id);
                $rack->gl_number = $gl_information->gl_number; 
                $rack->buyer_name = $gl_information->buyer_name; 
                $rack->po_no = $gl_information->po_no; 
                
                $product_information = $this->getProductInformation($pallet_transfer->id);
                $rack->colour = $product_information->colour; 
                
                $carton_information = $this->getCartonInformation($pallet_transfer->id);
                $rack->total_carton = $carton_information->total_carton; 
                $rack->total_pcs = $carton_information->total_pcs;

                $rack->transfer_note = $this->getTransferNoteList($pallet_transfer->id);

                
                $rack->pallet_serial_number = $pallet_transfer->serial_number; 
            } else {
                $rack->gl_number = '-'; 
                $rack->buyer_name = '-'; 
                $rack->po_no = '-'; 
                $rack->colour = '-'; 
                $rack->total_carton = '-'; 
                $rack->total_pcs = '-'; 
                $rack->pallet_serial_number = '-'; 
                $rack->transfer_note = '-';
            }
        }

        return $rack_list;
    }

    public function getPalletTransferInRack($rack_id)
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->join('tblrackpallet as rack_pallet' , 'rack_pallet.rack_id = rack.id');
        $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id');
        $builder->join('tblpallet as pallet', 'pallet.id = pallet_transfer.pallet_id');
        $builder->where('pallet_transfer.flag_transferred','Y');
        $builder->where('pallet_transfer.flag_loaded','N');
        $builder->where('rack.id',$rack_id);
        $builder->orderBy('pallet_transfer.created_at', 'DESC');
        $builder->select('pallet_transfer.*, pallet.serial_number');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getGlInformation($pallet_transfer_id)
    {
        $builder = $this->db->table('tblpallettransfer as pallet_transfer');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblpackinglist as pl', 'pl.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = pl.packinglist_po_id');
        $builder->join('tblsyncpurchaseorder as sync_po', 'sync_po.purchase_order_id = po.id');
        
        
        // !! peralihan dari gl_po ke sync_po. kedepannya query yang ini tolong di hapus
        // $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        // $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        // $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        
        $builder->where('pallet_transfer.id', $pallet_transfer_id);
        
        // $builder->groupBy('gl.id, po.po_no');
        $builder->groupBy('sync_po.id');
        $builder->select('sync_po.gl_number, sync_po.buyer_name, po.po_no');
        $gl_list = $builder->get()->getResult();

        $gl_number_list = array_map(function ($gl) { return $gl->gl_number; }, $gl_list);
        $gl_number_list = array_unique($gl_number_list);
        $gl_number = implode(', ', $gl_number_list);
        
        $buyer_name_list = array_map(function ($gl) { return $gl->buyer_name; }, $gl_list);
        $buyer_name_list = array_unique($buyer_name_list);
        $buyer_name = implode(', ', $buyer_name_list);

        $po_list = array_map(function ($gl) { return $gl->po_no; }, $gl_list);
        $po_list = array_unique($po_list);
        $po_no = implode(', ', $po_list);

        $result = (object)[
            'gl_number' => $gl_number,
            'buyer_name' => $buyer_name,
            'po_no' => $po_no,
        ];
        return $result;
    }

    public function getProductInformation($pallet_transfer_id)
    {
        $builder = $this->db->table('tblpallettransfer as pallet_transfer');
        $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->where('pallet_transfer.id', $pallet_transfer_id);
        $builder->groupBy('colour.id');
        $builder->select('colour.colour_name');
        $colour_list = $builder->get()->getResult();

        $colour_list = array_map(function ($colour) { return $colour->colour_name; }, $colour_list);
        $colour = implode(', ', $colour_list);

        $result = (object)[
            'colour' => $colour,
        ];

        return $result;
    }

    public function getCartonInformation($pallet_transfer_id)
    {
        $builder = $this->db->table('tblpallettransfer as pallet_transfer');
        $builder->join('tbltransfernote as transfer_note','transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->where('pallet_transfer.id', $pallet_transfer_id);
        $builder->where('carton_barcode.flag_loaded !=', 'Y');
        $builder->where('transfer_note_detail.deleted_at', null);
        $builder->groupBy('transfer_note_detail.id');
        $builder->select('transfer_note_detail.*, sum(carton_detail.product_qty) as pcs_per_carton');
        $carton_information = $builder->get()->getResult();
        
        $total_pcs = array_sum(array_column($carton_information,'pcs_per_carton'));
        $result = (object)[
            'total_carton' => count($carton_information),
            'total_pcs' => $total_pcs,
        ];
        
        return $result;
    }

    // !! fungsi ini tidak jadi di pakai. hapus nanti
    // public function getPalletByRackID($rack_id)
    // {
    //     $builder = $this->db->table('tblrack as rack');
    //     $builder->join('tblrackpallet as rack_pallet','rack_pallet.rack_id = rack.id');
    //     $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.id = rack_pallet.pallet_transfer_id');
    //     $builder->join('tblpallet as pallet','pallet.id = pallet_transfer.pallet_id');
    //     $builder->where('rack.id', $rack_id);
    //     $builder->orderBy('rack_pallet.created_at', 'DESC');
    //     $builder->select('pallet.*');
    //     $result = $builder->get()->getRow();
    //     return $result;
    // }

    public function getTransferNoteList($pallet_transfer_id)
    {
        $PalletTransferModel = model('PalletTransferModel');
        $transfer_note_list = $PalletTransferModel->getTransferNotes($pallet_transfer_id);

        $transfer_note_number_list = array_map(function ($transfer_note) { return $transfer_note->serial_number; }, $transfer_note_list);
        $transfer_note_number_list = array_unique($transfer_note_number_list);
        $transfer_note_number = implode(', ', $transfer_note_number_list);

        return $transfer_note_number;
    }
    public function updateLastRackPallet($rack_id, $data_update)
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->join('tblrackpallet as rack_pallet','rack_pallet.rack_id = rack.id');
        $builder->where('rack.id', $rack_id);
        $builder->orderBy('rack_pallet.created_at', 'DESC');
        $builder->select('rack_pallet.*');
        $rack_pallet = $builder->get()->getRow();

        $RackPalletModel = model('RackPalletModel');
        $result = $RackPalletModel->update($rack_pallet->id, $data_update);
        return $result;
    }

    public function searchPalletTransferInRack($pallet_id)
    {
        $builder = $this->db->table('tblrack as rack');
        $builder->join('tblrackpallet as rack_pallet','rack_pallet.rack_id = rack.id');
        $builder->join('tblpallettransfer as pallet_transfer','pallet_transfer.id = rack_pallet.pallet_transfer_id');
        $builder->join('tbllocation as location_from','location_from.id = pallet_transfer.location_from_id');
        $builder->join('tbllocation as location_to','location_to.id = pallet_transfer.location_to_id');
        $builder->join('tblpallet as pallet','pallet.id = pallet_transfer.pallet_id');
        $builder->join('tbltransfernote as transfer_note','transfer_note.pallet_transfer_id = pallet_transfer.id');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id');

        $builder->where('pallet.id',$pallet_id);
        $builder->where('rack_pallet.out_date', null);
        $builder->orderBy('rack_pallet.created_at', 'DESC');
        
        $builder->select([
            'pallet.id', 
            'pallet.id as pallet_id', 
            'pallet.serial_number as pallet_number', 
            'pallet.flag_empty', 
            'rack.serial_number as rack_serial_number', 
            'location_from.location_name as location_from', 
            'location_to.location_name as location_to', 
            'pallet_transfer.id as pallet_transfer_id', 
            'pallet_transfer.flag_ready_to_transfer', 
            'pallet_transfer.flag_transferred', 
            'pallet_transfer.flag_loaded', 
            'COUNT(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN transfer_note_detail.id END) as total_carton',
        ]);
        $pallet_transfer = $builder->get()->getRow();

        return $pallet_transfer;
    }

}
