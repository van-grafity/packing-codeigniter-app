<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class CartonBarcodeModel extends Model
{
    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
    ];


    public function update_barcode($data_array)
    {
        $additionalUpdateField = ['updated_at' => new RawSql('CURRENT_TIMESTAMP')];
        $builder = $this->db->table('tblcartonbarcode');
        $builder->updateFields($additionalUpdateField, true);
        $builder->updateBatch($data_array, ['packinglist_carton_id','carton_number_by_system']);
    }

    public function update_barcode_v2($data_array)
    {
        foreach ($data_array as $key => $value) {
            $builder = $this->db->table('tblcartonbarcode');
            $builder->where('packinglist_carton_id', $value['packinglist_carton_id']);
            $builder->update($value);
        }
    }

    public function get_carton_by_packinglist($packinglist_id)
    {
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.id, carton_barcode.carton_number_by_system as carton_number, carton_barcode.barcode as barcode, colour.colour_name as colour, size.size');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->join('tblsizes as size', 'size.id = product.product_size_id');
        $builder->orderBy('carton_barcode.id');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $result = $builder->get()->getResult();
        return $result;
    }
}

