<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class CartonBarcodeModel extends Model
{
    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'packinglist_id',
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
        'flag_packed',
    ];


    public function updateCartonBarcode($data_array)
    {
        $additionalUpdateField = ['updated_at' => new RawSql('CURRENT_TIMESTAMP')];
        $builder = $this->db->table('tblcartonbarcode');
        $builder->updateFields($additionalUpdateField, true);
        $result = $builder->updateBatch($data_array, ['packinglist_id', 'carton_number_by_system']);
        return $result;
    }

    public function getCartonByPackinglist($packinglist_id)
    {
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.id, carton_barcode.carton_number_by_system as carton_number, carton_barcode.barcode as barcode, carton_barcode.flag_packed, sum(carton_detail.product_qty) as pcs_per_carton');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->groupBy('carton_barcode.id');
        $builder->orderBy('carton_number');
        $builder->where('pl_carton.packinglist_id', $packinglist_id);
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getLastNumber($packinglist_id)
    {
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.carton_number_by_system as carton_number');
        $builder->where('carton_barcode.packinglist_id', $packinglist_id);
        $builder->orderBy('carton_number_by_system', 'desc');
        $result = $builder->get()->getRow();
        return $result ? $result->carton_number : 0;
    }

    public function getDetailCarton($carton_id = null)
    {
        if (!$carton_id) return null;

        $data_return = [];

        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('product.product_code, product.product_name as product_name, size.size as product_size, carton_detail.product_qty, colour.colour_name as product_colour');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblsize as size', 'size.id = product.product_size_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->where('carton_barcode.id', $carton_id);
        $result = $builder->get()->getResult();

        return $result;
    }

    public function getDetailCartonByBarcode($carton_barcode = null)
    {
        if (!$carton_barcode) return null;

        $data_return = [];

        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('product.product_code, product.product_name as product_name, size.size as product_size, carton_detail.product_qty, colour.colour_name as product_colour');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblsizes as size', 'size.id = product.product_size_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->where('carton_barcode.barcode', $carton_barcode);
        $result = $builder->get()->getResult();

        return $result;
    }

    public function getCartonInfoByBarcode($carton_barcode = null)
    {
        if (!$carton_barcode) return null;

        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.id as carton_id, po.po_no as po_number, packinglist.id as packinglist_id, packinglist.packinglist_serial_number as pl_number, buyer.buyer_name as buyer, carton_barcode.carton_number_by_system as carton_number');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblpackinglist as packinglist', 'packinglist.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblgl as gl', 'gl.id = po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');

        $builder->where('carton_barcode.barcode', $carton_barcode);
        $result = $builder->get()->getRow();
        return $result;
    }
}
