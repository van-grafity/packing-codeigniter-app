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
        $builder->groupBy('inspection.id');

        if($id) {
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
        $builder->select('carton_barcode.carton_number_by_system as carton_number, carton_barcode.barcode as carton_barcode, sum(carton_detail.product_qty) as total_pcs');
        $builder->join('tblcartoninspection as inspection', 'inspection.id = inspection_detail.carton_inspection_id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = inspection_detail.carton_barcode_id');
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->groupBy('carton_barcode.id');
        $builder->where('inspection_detail.carton_inspection_id', $inspection_id);
        $result = $builder->get()->getResult();
        
        return $result;
    }
}
