<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListModel extends Model
{
    protected $table = 'tblpackinglist';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'packinglist_no',
        'packinglist_date',
        'packinglist_po_id',
        'packinglist_qty',
        'packinglist_amount',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'packinglist_created_at';
    protected $updatedField = 'packinglist_updated_at';

    public function getPackingList()
    {
        $builder = $this->db->table('tblpackinglist');
        $builder->select('*');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id');
        return $builder->get();
    }

    public function getPO()
    {
        $builder = $this->db->table('tblpurchaseorder');
        $builder->select('*');
        $builder->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id');
        $builder->join('tblfactory', 'tblfactory.id = tblpurchaseorder.factory_id');
        return $builder->get();
    }

    public function savePackingList($data)
    {
        $query = $this->db->table('tblpackinglist')->insert($data);
        return $query;
    }
}
