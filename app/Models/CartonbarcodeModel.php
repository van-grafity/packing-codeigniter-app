<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonBarcodeModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblCarton_Barcode';
    protected $allowedFields = [
        'carton_pl_id',
        'carton_no',
        'carton_barcode'
    ];

    public function getCartonBarcode()
    {
        $builder = $this->db->table('tblcarton_barcode');
        $builder->select('*');
        $builder->join('tblpackinglist', 'tblpackinglist.id = carton_pl_id', 'left');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id', 'left');
        return $builder->get();
    }

    public function getCartonRatio()
    {
        $builder = $this->db->table('tblcartonratio');
        $builder->select('*, tblsizes.size as size_name');
        $builder->join('tblcartonbarcode', 'tblcartonbarcode.id = cartonbarcode_id', 'left');
        $builder->join('tblpackinglist', 'tblpackinglist.id = tblcartonbarcode.carton_pl_id', 'left');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id', 'left');
        $builder->join('tblsizes', 'tblsizes.id = size_id', 'left');
        return $builder->get();
    }

    public function getSize()
    {
        $builder = $this->db->table('tblsizes');
        $builder->select('*');
        return $builder->get();
    }
}
