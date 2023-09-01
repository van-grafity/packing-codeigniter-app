<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonInspectionModel extends Model
{
    protected $table            = 'tblcartoninspection';
    protected $useTimestamps    = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['issued_by','received_by','issued_date'];

    public function getCartonInspection($id = null)
    {
        $GlModel = model('GlModel');

        $builder = $this->db->table('tblcartoninspection inspection');
        $builder->select('inspection.id, po.id as po_id, po.po_no as po_number, packinglist.packinglist_serial_number as pl_number, inspection.issued_by, inspection.received_by, inspection.issued_date, count(inspection_detail.id) as total_carton');
        $builder->join('tblcartoninspectiondetail as inspection_detail','inspection_detail.carton_inspection_id = inspection.id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = inspection_detail.carton_barcode_id');
        $builder->join('tblpackinglist as packinglist','packinglist.id = carton_barcode.packinglist_id');
        $builder->join('tblpurchaseorder as po','po.id = packinglist.packinglist_po_id');
        $builder->groupBy('inspection.id, po.id, po.po_no,packinglist.packinglist_serial_number, inspection.issued_by, inspection.received_by, inspection.issued_date');
        $builder->orderBy('inspection.created_at','ASC');

        if($id){
            $builder->where('inspection.id',$id);
            $result = $builder->get()->getRow();
            $result = $GlModel->set_gl_info_on_po($result,$result->po_id);
            
        } else {
            $result = $builder->get()->getResult();
            foreach ($result as $key => $inspection) {
                $inspection = $GlModel->set_gl_info_on_po($inspection, $inspection->po_id);
                $result[$key] = $inspection;
            }
        }
        return $result;
    }

    public function getCartonInspectionDetail($inspection_id = null)
    {
        if(!$inspection_id) { return null; }

        $builder = $this->db->table('tblcartoninspectiondetail as inspection_detail');
        $builder->select('carton_barcode.carton_number_by_system as carton_number, pl_carton.id as pl_carton_id, carton_barcode.barcode as carton_barcode, sum(carton_detail.product_qty) as total_pcs');
        $builder->join('tblcartoninspection as inspection', 'inspection.id = inspection_detail.carton_inspection_id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = inspection_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->groupBy('carton_barcode.id');
        $builder->where('inspection_detail.carton_inspection_id', $inspection_id);
        $result = $builder->get()->getResult();

        foreach ($result as $carton_key => $carton) {
            $builder_size = $this->db->table('tblpackinglistcarton as pl_carton');
            $builder_size->select('size.size, carton_detail.product_qty as qty_size');
            $builder_size->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = pl_carton.id');
            $builder_size->join('tblproduct as product','product.id = carton_detail.product_id');
            $builder_size->join('tblsize as size','size.id = product.product_size_id');
            $builder_size->where('pl_carton.id', $carton->pl_carton_id);
            $builder_size->orderBy('size.id', 'ASC');
            $size_list = $builder_size->get()->getResult();

            $qty_per_size = array();
            foreach ($size_list as $size_key => $size) {
                $qty_per_size[] = $size->size . ' = ' . $size->qty_size;
            }
            $qty_in_carton = join(' | ', $qty_per_size);
            $result[$carton_key]->size_list = $qty_in_carton;
        }
        
        return $result;
    }

    public function deleteInspectionDetail($inspection_id = null)
    {
        if(!$inspection_id) { return null; }
        $CartonInspectionDetailModel = model('CartonInspectionDetailModel');
        $CartonBarcodeModel = model('CartonBarcodeModel');
        
        $get_inspection_detail = $CartonInspectionDetailModel->where('carton_inspection_id',$inspection_id)->findAll();

        foreach ($get_inspection_detail as $key => $inspection_detail) {
            $CartonBarcodeModel->update($inspection_detail['carton_barcode_id'], ['flag_packed' => 'Y']);
        }
        $delete_inspection_detail = $CartonInspectionDetailModel->where('carton_inspection_id',$inspection_id)->delete();
        
        return count($get_inspection_detail);
    }
}
