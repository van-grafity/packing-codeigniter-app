<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferNoteModel extends Model
{

    protected $table         = 'tbltransfernote';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields = ['pallet_transfer_id','serial_number','issued_by','authorized_by','received_by','received_at'];

    public function getTransferNote($transfer_note_id = null)
    {
        if ($transfer_note_id) {
            return $this->where(['id' => $transfer_note_id])->first();
        }
        return $this->db->table($this->table)->get()->getResult();
    }

    public function countTransferNoteThisMonth($year_filter = null, $month_filter = null)
    {
        $month_filter = $month_filter ? $month_filter : date('m');
        $year_filter = $year_filter ? $year_filter : date('Y');

        $builder = $this->db->table($this->table);
        $builder->select('count(id) as total_transfer_note');
        $builder->where("MONTH(created_at)", $month_filter);
        $builder->where("YEAR(created_at)", $year_filter);
        $result = $builder->get()->getRow();
        return $result->total_transfer_note;
    }

    public function getCartonInTransferNote($transfer_note_id, $where_options = [])
    {
        if (!$transfer_note_id) return null;
        
        $GlModel = model('GlModel');
        $CartonBarcodeModel = model('CartonBarcodeModel');
        
        $builder = $this->db->table('tbltransfernote as transfer_note');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tblcartonbarcode as carton_barcode', 'carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblpackinglist as packinglist', 'packinglist.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        
        $builder->where('transfer_note.id', $transfer_note_id);
        $builder->where('transfer_note_detail.deleted_at', null);
        if($where_options){
            $builder->where($where_options);
        }

        $builder->orderBy('carton_barcode.carton_number_by_system', 'ASC');

        $builder->select('carton_barcode.id as carton_id, carton_barcode.flag_packed, carton_barcode.barcode as carton_barcode, po.po_no as po_number, packinglist.id as packinglist_id, packinglist.packinglist_serial_number as pl_number, carton_barcode.carton_number_by_system as carton_number');
        $carton_list = $builder->get()->getResult();
        
        if(!$carton_list) { return null; }

        foreach ($carton_list as $key => $carton) {
            
            $carton_with_gl_info = $GlModel->set_gl_info_on_carton($carton, $carton->carton_id);

            $size_list_in_carton = $CartonBarcodeModel->getCartonContent($carton->carton_id);
            $carton_with_gl_info->content = $CartonBarcodeModel->serialize_size_list($size_list_in_carton);
            $carton_with_gl_info->total_pcs = array_sum(array_column($size_list_in_carton,'qty'));

            $carton_list[$key] = $carton_with_gl_info;
        }
        
        return $carton_list;
    }

    public function deleteTransferNote($transfer_note_id)
    {
        //## delete transfer note detail
        $TransferNoteDetailModel = model('TransferNoteDetailModel');
        $TransferNoteDetailModel->where('transfer_note_id',$transfer_note_id)->delete();
        
        //## delete transfer note
        $delete_transfer_note = $this->where('id', $transfer_note_id)->delete();
    }

    public function isCartonAvailable($carton_barcode)
    {
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->join('tbltransfernotedetail as transfer_note_detail', 'transfer_note_detail.carton_barcode_id = carton_barcode.id');
        $builder->where('transfer_note_detail.deleted_at', null);
        $builder->where('carton_barcode.barcode', $carton_barcode);
        $result = $builder->get()->getResult();
        
        if($result){
            return false;
        } else {
            return true;
        }
    }

    public function getPackingTransferNote($transfer_note_id)
    {
        $builder = $this->db->table('tbltransfernote as transfer_note');
        $builder->join('tblpallettransfer as pallet_transfer', 'pallet_transfer.id = transfer_note.pallet_transfer_id');
        $builder->join('tbllocation as location_from', 'location_from.id = pallet_transfer.location_from_id');
        $builder->join('tbllocation as location_to', 'location_to.id = pallet_transfer.location_to_id');
        $builder->join('tblpallet as pallet', 'pallet.id = pallet_transfer.pallet_id');
        $builder->where('transfer_note.id', $transfer_note_id);
        $builder->select('transfer_note.id as transfer_note_id, transfer_note.serial_number as transfer_note_number, DATE(transfer_note.created_at) as issued_date, transfer_note.issued_by, transfer_note.authorized_by, location_from.location_name as location_from, location_to.location_name as location_to, pallet.serial_number as pallet_number');
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getTransferNoteDetail($transfer_note_id)
    {
        $GlModel = model('GlModel');
        $CartonBarcodeModel = model('CartonBarcodeModel');

        $builder = $this->db->table('tbltransfernotedetail as transfer_note_detail');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as packinglist_carton','packinglist_carton.id = carton_barcode.packinglist_carton_id');
        // $builder->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = packinglist_carton.id');
        $builder->join('tblpackinglist as packinglist','packinglist.id = packinglist_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po','po.id = packinglist.packinglist_po_id');
        $builder->where('transfer_note_detail.transfer_note_id', $transfer_note_id);
        $builder->where('transfer_note_detail.deleted_at', null);
        $builder->select('po.id as po_id, po.po_no as po_number, carton_barcode.packinglist_carton_id, SUM(CASE WHEN transfer_note_detail.deleted_at IS NULL THEN 1 ELSE 0 END) as total_carton');
        $builder->groupBy('packinglist_carton.id');
        $transfer_note_detail = $builder->get()->getResult();

        foreach ($transfer_note_detail as $key => $packinglist_carton) {
            $transfer_note_detail[$key] = $GlModel->set_gl_info_on_po($packinglist_carton,$packinglist_carton->po_id);
            
            $carton_content = $CartonBarcodeModel->getCartonContentByPackinglistCarton($packinglist_carton->packinglist_carton_id);
            $transfer_note_detail[$key]->carton_content = $carton_content;
            $transfer_note_detail[$key]->qty_each_carton = array_sum(array_column($carton_content,'qty'));
            $transfer_note_detail[$key]->total_pcs = $packinglist_carton->total_carton  * $packinglist_carton->qty_each_carton;
        }
        
        return $transfer_note_detail;
    }

    public function getCartonLoadStatusByTransfernote($transfer_note_id, $load_status = null)
    {
        $builder = $this->db->table('tbltransfernote as transfer_note');
        $builder->join('tbltransfernotedetail as transfer_note_detail','transfer_note_detail.transfer_note_id = transfer_note.id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = transfer_note_detail.carton_barcode_id');
        $builder->where('transfer_note.id', $transfer_note_id);
        $builder->where('carton_barcode.deleted_at', null);
        if($load_status) {
            $builder->where('carton_barcode.flag_loaded', $load_status);
        }
        $builder->select('carton_barcode.*');
        $result = $builder->get()->getResult();
        return $result;
    }

}
