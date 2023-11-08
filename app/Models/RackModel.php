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

    // public function getRackInformation($rack_id = null)
    // {
    //     $builder = $this->db->table('tblrack as rack');
    //     $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.rack_id = rack.id','left');
    //     $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id','left');
    //     $builder->join('tbltransfernote as transfer_note', 'transfer_note.pallet_transfer_id = pallet_transfer.id','left');
    //     $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id','left');
    //     $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.id = transfer_note_detail.carton_barcode_id','left');
    //     $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id','left');
    //     $builder->join('tblpackinglist as pl', 'pl.id = pl_carton.packinglist_id','left');
    //     $builder->join('tblpurchaseorder as po', 'po.id = pl.packinglist_po_id','left');
    //     $builder->groupBy('rack.id, rack.serial_number, rack.description, rack.flag_empty, pallet_transfer.id');
    //     $builder->select('rack.id, rack.serial_number, rack.description, rack.flag_empty, pallet_transfer.id as pallet_transfer_id');

    //     $result = $builder->get()->getResult();
    //     return $builder;
    // }

    public function getRackInformation_array($params)
    {
        $builder = $this;
        $builder->join('tblrackpallet as rack_pallet', 'rack_pallet.rack_id = tblrack.id','left');
        $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = rack_pallet.pallet_transfer_id','left');
        $builder->select('tblrack.id, tblrack.serial_number, tblrack.description, tblrack.flag_empty, pallet_transfer.id as pallet_transfer_id');
        $rack_list = $builder->paginate($params['length'], 'default',$params['start']);
        $pager = $builder->pager;

        foreach ($rack_list as $key_rack => $rack) {
            if($rack->pallet_transfer_id){
                $gl_information = $this->getGlInformation($rack->pallet_transfer_id);
                $rack->gl_number = $gl_information->gl_number; 
                $rack->buyer_name = $gl_information->buyer_name; 
                $rack->po_no = $gl_information->po_no; 
                
                $product_information = $this->getProductInformation($rack->pallet_transfer_id);
                $rack->colour = $product_information->colour; 
                
                $carton_information = $this->getCartonInformation($rack->pallet_transfer_id);
                $rack->total_carton = $carton_information->total_carton; 
                $rack->total_pcs = $carton_information->total_pcs; 
                
            } else {
                $rack->gl_number = '-'; 
                $rack->buyer_name = '-'; 
                $rack->po_no = '-'; 
                $rack->colour = '-'; 
                $rack->total_carton = '-'; 
                $rack->total_pcs = '-'; 
            }
        }
        $result = [
            'rack_list' => $rack_list,
            'pager' => $pager,
        ];
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
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where('pallet_transfer.id', $pallet_transfer_id);
        $builder->groupBy('gl.id, po.po_no');
        $builder->select('gl.gl_number, buyer.buyer_name, po.po_no');
        $gl_list = $builder->get()->getResult();

        $gl_number_list = array_map(function ($gl) { return $gl->gl_number; }, $gl_list);
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

}
