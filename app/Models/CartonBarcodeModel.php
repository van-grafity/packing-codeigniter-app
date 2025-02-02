<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class CartonBarcodeModel extends Model
{
    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'packinglist_id',
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
        'flag_packed',
        'packed_at',
        'flag_loaded',
        'loaded_at',
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
        $builder->where('carton_barcode.deleted_at', null);
        $builder->where('pl_carton.deleted_at', null);
        $builder->where('carton_detail.deleted_at', null);
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
        $builder->where('carton_detail.deleted_at', null);
        $builder->orderBy('size.size_order', 'asc');
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
        $builder->join('tblsize as size', 'size.id = product.product_size_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        $builder->where('carton_barcode.barcode', $carton_barcode);
        $builder->where('carton_detail.deleted_at', null);
        $builder->orderBy('size.size_order', 'asc');
        $result = $builder->get()->getResult();

        return $result;
    }

    public function getCartonInfoByBarcode($carton_barcode = null)
    {
        if (!$carton_barcode) return null;

        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.id as carton_id, carton_barcode.flag_packed, po.po_no as po_number, packinglist.id as packinglist_id, packinglist.packinglist_serial_number as pl_number, buyer.buyer_name as buyer, carton_barcode.carton_number_by_system as carton_number');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblpackinglist as packinglist', 'packinglist.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');

        $builder->where('carton_barcode.barcode', $carton_barcode);
        $result = $builder->get()->getRow();
        return $result;
    }

    public function getCartonInfoByBarcode_v2($carton_barcode = null)
    {
        if (!$carton_barcode) return null;

        $GlModel = model('GlModel');
        
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->select('carton_barcode.id as carton_id, carton_barcode.flag_packed, carton_barcode.barcode as carton_barcode, po.po_no as po_number, packinglist.id as packinglist_id, packinglist.packinglist_serial_number as pl_number, carton_barcode.carton_number_by_system as carton_number');
        $builder->join('tblpackinglistcarton as pl_carton', 'pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblpackinglist as packinglist', 'packinglist.id = pl_carton.packinglist_id');
        $builder->join('tblpurchaseorder as po', 'po.id = packinglist.packinglist_po_id');

        $builder->where('carton_barcode.barcode', $carton_barcode);
        $result = $builder->get()->getRow();
        if(!$result) { return null; }

        $carton_with_gl_info = $GlModel->set_gl_info_on_carton($result, $result->carton_id);
        return $carton_with_gl_info;
    }

    public function getCartonContent($carton_barcode_id, $serialize_options = false)
    {
        $builder = $this->db->table('tblcartonbarcode as carton_barcode');
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = carton_barcode.packinglist_carton_id');
        $builder->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product','product.id = carton_detail.product_id');
        $builder->join('tblsize as size','size.id = product.product_size_id');
        $builder->where('carton_barcode.id', $carton_barcode_id);
        $builder->where('carton_detail.deleted_at', null);
        $builder->select('product.product_name, size.size, carton_detail.product_qty as qty');
        $result = $builder->get()->getResult();
        
        if(!$serialize_options){
            return $result;
        }

        return $this->serialize_size_list($result);

    }

    public function serialize_size_list($size_list)
    {
        $array_size_qty = [];
        foreach ($size_list as $key => $size) {
            $combine_size_qty = $size->size.' = '.$size->qty;
            $array_size_qty[] = $combine_size_qty;
        }

        $result = implode(' | ', $array_size_qty);
        return $result;
    }

    public function getCartonContentByPackinglistCarton($packinglist_carton_id, $serialize_options = false)
    {
        $builder = $this->db->table('tblpackinglistcarton as pl_carton');
        $builder->join('tblcartondetail as carton_detail','carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product','product.id = carton_detail.product_id');
        $builder->join('tblsize as size','size.id = product.product_size_id');
        $builder->join('tblcolour as colour','colour.id = product.product_colour_id');
        $builder->where('pl_carton.id', $packinglist_carton_id);
        $builder->where('carton_detail.deleted_at', null);
        $builder->select('product.product_name, size.size, colour.colour_name as colour, carton_detail.product_qty as qty');
        $result = $builder->get()->getResult();
        
        if(!$serialize_options){
            return $result;
        }

        return $this->serialize_size_list($result);

    }

    public function unpackCarton($packinglist_id = null, $carton_barcode_id = null)
    {
        $updated_carton = [];
        $carton_barcode_list = [];

        $builder = $this->builder();
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = tblcartonbarcode.packinglist_carton_id');
        $builder->join('tblpackinglist as pl','pl.id = pl_carton.packinglist_id');
        $builder->where('pl.id',$packinglist_id);
        $builder->where('tblcartonbarcode.flag_packed','Y');
        if($carton_barcode_id){
            $builder->where('tblcartonbarcode.id',$carton_barcode_id);
        }
        $builder->select('tblcartonbarcode.*');
        $carton_barcode_list = $builder->get()->getResultArray();
        
        $carton_barcode_id_list = array_column($carton_barcode_list, 'id');
        if($carton_barcode_id_list){
            $updated_carton = $this->whereIn('id', $carton_barcode_id_list)
                ->set(['flag_packed' => 'N'])
                ->update();
        }

        if($updated_carton){
            return $carton_barcode_list;
        } else {
            return $carton_barcode_list;
        }
    }

    public function clearBarcode($packinglist_id = null, $carton_barcode_id = null)
    {
        $updated_carton = [];
        $carton_barcode_list = [];

        $builder = $this->builder();
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = tblcartonbarcode.packinglist_carton_id');
        $builder->join('tblpackinglist as pl','pl.id = pl_carton.packinglist_id');
        $builder->where('pl.id',$packinglist_id);
        $builder->where('tblcartonbarcode.barcode !=', '');
        if($carton_barcode_id){
            $builder->where('tblcartonbarcode.id',$carton_barcode_id);
        }
        $builder->select('tblcartonbarcode.*');
        $carton_barcode_list = $builder->get()->getResultArray();
        
        $carton_barcode_id_list = array_column($carton_barcode_list, 'id');
        if($carton_barcode_id_list){
            $updated_carton = $this->whereIn('id', $carton_barcode_id_list)
                ->set(['barcode' => null])
                ->update();
        }

        if($updated_carton){
            return $carton_barcode_list;
        } else {
            return $carton_barcode_list;
        }
    }


    public function deleteCarton($packinglist_id = null, $carton_barcode_id = null)
    {
        $updated_carton = [];
        $carton_barcode_list = [];

        $builder = $this->builder();
        $builder->join('tblpackinglistcarton as pl_carton','pl_carton.id = tblcartonbarcode.packinglist_carton_id');
        $builder->join('tblpackinglist as pl','pl.id = pl_carton.packinglist_id');
        $builder->where('pl.id',$packinglist_id);
        $builder->where('tblcartonbarcode.flag_packed','N');
        $builder->where('tblcartonbarcode.barcode', '');
        if($carton_barcode_id){
            $builder->where('tblcartonbarcode.id',$carton_barcode_id);
        }
        $builder->select('tblcartonbarcode.*');
        $carton_barcode_list = $builder->get()->getResultArray();
        
        $carton_barcode_id_list = array_column($carton_barcode_list, 'id');
        if($carton_barcode_id_list){
            $updated_carton = $this->whereIn('id', $carton_barcode_id_list)
                ->delete();
        }

        if($updated_carton){
            return $carton_barcode_list;
        } else {
            return $carton_barcode_list;
        }
    }
}
