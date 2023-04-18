<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonBarcodeModel extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tblCartonBarcode';
    protected $allowedFields = [
        'carton_pl_id',
        'carton_no',
        'carton_barcode'
    ];

    public function getCartonBarcode()
    {
        $builder = $this->db->table('tblcartonbarcode');
        $builder->select('*');
        $builder->join('tblpackinglist', 'tblpackinglist.id = carton_pl_id', 'left');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = packinglist_po_id', 'left');
        return $builder->get();
    }
}
