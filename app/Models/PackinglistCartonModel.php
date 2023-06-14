<?php

namespace App\Models;

use CodeIgniter\Model;

class PackinglistCartonModel extends Model
{
    protected $table            = 'tblpackinglistcarton';
    protected $useTimestamps    = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'packinglist_id',
        'carton_qty',
        'gross_weight',
        'net_weight',
        'carton_number_from',
        'carton_number_to',
        'flag_generate_carton',
    ];

    public function getDataByPackinglist($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglistcarton as pl_carton');
        $builder->select('pl_carton.*, pl_carton.id as pl_carton_id, sum(carton_detail.product_qty) as pcs_per_carton');
        $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        if ($packinglist_id) {
            $builder->where(['pl_carton.packinglist_id' => $packinglist_id]);
        }
        $builder->groupBy('pl_carton_id');
        $builder->orderBy('pl_carton.id');
        $result = $builder->get()->getResult();

        return $result;
    }

    public function getUngeneratedCartonByPackinglistID($packinglist_id = null)
    {
        $builder = $this->db->table('tblpackinglistcarton as pl_carton');
        $builder->select('pl_carton.*');
        // $builder->join('tblcartondetail as carton_detail', 'carton_detail.packinglist_carton_id = pl_carton.id');
        // $builder->join('tblproduct as product', 'product.id = carton_detail.product_id');
        // $builder->join('tblcolour as colour', 'colour.id = product.product_colour_id');
        if ($packinglist_id) {
            $builder->where(['pl_carton.packinglist_id' => $packinglist_id]);
        }
        $builder->where(['pl_carton.flag_generate_carton' => 'N']);
        // $builder->groupBy('pl_carton.id, colour.id');
        // $builder->orderBy('pl_carton.id');
        $result = $builder->get()->getResult();

        return $result;
    }

    public function getProductsInCarton($carton_id = null)
    {
        if (!$carton_id) return null;

        $data_return = [];
        $products_in_carton = model('App\Models\CartonDetailModel')->where('packinglist_carton_id', $carton_id)->find();
        foreach ($products_in_carton as $key => $product) {
            $product_data = $this->db->table('tblproduct as product')
                ->join('tblcolour as colour', 'colour.id = product.product_colour_id')
                ->join('tblsize as size', 'size.id = product.product_size_id')
                ->select('product.id as product_id, product_name, product_code, colour.colour_name as colour, size.id as size_id, size.size')
                ->where('product.id', $product->product_id)
                ->get()->getRow();

            $product_data->product_qty = $product->product_qty;
            $product_data->carton_detail_id = $product->id;
            $data_return[] = $product_data;
        }
        return $data_return;
    }
}
