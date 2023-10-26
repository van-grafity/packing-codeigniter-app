<?php

namespace App\Models;

use CodeIgniter\Model;

class SyncPurchaseOrderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tblsyncpurchaseorder';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['purchase_order_id','buyer_name','gl_number','season'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getBuyerByPurchaseOrder($purchase_order_id)
    {
        $builder = $this->db->table('tblpurchaseorder as po');
        $builder->select('buyer.id as buyer_id, buyer.buyer_name');
        $builder->join('tblgl_po as gl_po', 'gl_po.po_id = po.id');
        $builder->join('tblgl as gl', 'gl.id = gl_po.gl_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where(['po.id' => $purchase_order_id]);
        $builder->groupBy('buyer.id');
        $builder->orderBy('po.created_at','DESC');
        $result = $builder->get()->getResult();
        return $result;
    }

    public function getGlByPurchaseOrder($purchase_order_id)
    {
        $builder = $this->db->table('tblgl as gl');
        $builder->select('gl.gl_number, gl.season, buyer.buyer_name');
        $builder->join('tblgl_po as gl_po', 'gl_po.gl_id = gl.id');
        $builder->join('tblpurchaseorder as po', 'po.id = gl_po.po_id');
        $builder->join('tblbuyer as buyer', 'buyer.id = gl.buyer_id');
        $builder->where('po.id',$purchase_order_id);
        $gl_list = $builder->get()->getResult();
        return $gl_list;
    }

    public function createOrUpdate($purchase_order_data)
    {
        $sync_po_data = $this->where('purchase_order_id',$purchase_order_data['purchase_order_id'])->get()->getRow();
        if(!$sync_po_data){
            $this->insert($purchase_order_data);
        } else {
            $this->update($sync_po_data->id,$purchase_order_data);
        }
        $lastData = $this->where('purchase_order_id', $purchase_order_data['purchase_order_id'])->get()->getRow();
        return $lastData;
    }
}
