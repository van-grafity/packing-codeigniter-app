<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderDetailModel extends Model
{
    protected $table            = 'tblpurchaseorderdetail';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'order_id',
        'style_id',
        'size_id',
        'product_id',
        'price',
        'qty',
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;

    public function getPODetailSizeStyle()
    {
        $builder = $this->db->table('tblpurchaseorderdetail');
        $builder->select('tblpurchaseorderdetail.*, tblpurchaseorder.PO_No, tblpurchaseorderdetail.id as detail_id, tblstyles.style_description, tblstyles.style_no, tblsizes.size, tblproduct.product_name');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpurchaseorderdetail.order_id');
        $builder->join('tblstyles', 'tblstyles.id = tblpurchaseorderdetail.style_id');
        $builder->join('tblsizes', 'tblsizes.id = tblpurchaseorderdetail.size_id');
        $builder->join('tblproduct', 'tblproduct.id = tblpurchaseorderdetail.product_id');
        return $builder->get();
    }
}
