<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListSizeModel extends Model
{
    protected $useTimestamps = true;
    protected $table            = 'tblpackinglistsizes';
    protected $allowedFields    = [
        'packinglistsize_pl_id',
        'packinglistsize_size_id',
        'packinglistsize_qty',
        'packinglistsize_amount',
    ];

    public function getPackingListSize()
    {
        $builder = $this->db->table('tblpackinglistsizes');
        $builder->select('*');
        $builder->join('tblpackinglist', 'tblpackinglist.id = packinglistsize_pl_id', 'left');
        $builder->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id', 'left');
        $builder->join('tblsizes', 'tblsizes.id = packinglistsize_size_id', 'left');
        return $builder->get();
    }

    public function getSize()
    {
        $builder = $this->db->table('tblsizes');
        $builder->select('*');
        return $builder->get();
    }

    public function savePackingListSize($data)
    {
        $query = $this->db->table('tblpackinglistsizes')->insert($data);
        return $query;
    }
}
