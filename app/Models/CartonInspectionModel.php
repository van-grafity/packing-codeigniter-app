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
        $builder = $this->db->table('tblcartoninspection inspection');
        $builder->select('inspection.id, po.po_no as po_number, packinglist.packinglist_serial_number as pl_number, inspection.issued_by, inspection.received_by, inspection.issued_date, count(inspection_detail.id) as total_carton');
        $builder->join('tblcartoninspectiondetail as inspection_detail','inspection_detail.carton_inspection_id = inspection.id');
        $builder->join('tblcartonbarcode as carton_barcode','carton_barcode.id = inspection_detail.carton_barcode_id');
        $builder->join('tblpackinglist as packinglist','packinglist.id = carton_barcode.packinglist_id');
        $builder->join('tblpurchaseorder as po','po.id = packinglist.packinglist_po_id');
        $builder->groupBy('inspection.id');
        $result = $builder->get()->getResult();
        return $result;
    }
}
