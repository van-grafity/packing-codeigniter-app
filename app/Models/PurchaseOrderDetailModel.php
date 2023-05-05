<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tblpurchaseorderdetail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id',
        'style_id',
        'size_id',
        'product_id',
        'price',
        'qty',
    ];

    // Dates
    protected $useTimestamps = true;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

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
