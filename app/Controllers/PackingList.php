<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PackingListModel;
use App\Models\PackingListSizeModel;

class PackingList extends BaseController
{
    protected $pl;

    public function __construct()
    {
        $this->pl = new PackingListModel();
        $this->plsize = new PackingListSizeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*, tblpurchaseorder.PO_No, tblbuyer.buyer_name, tblgl.gl_number, tblgl.season, tblgl.size_order')
                ->join('tblpurchaseorder', 'tblpurchaseorder.id = tblpackinglist.packinglist_po_id')
                ->join('tblgl', 'tblgl.id = tblpurchaseorder.gl_id')
                ->join('tblbuyer', 'tblbuyer.id = tblgl.buyer_id')
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/index', $data);
    }
//     class PackingListSize extends Migration
// {
//     public function up()
//     {
//         $this->forge->addField([
//             'id' => [
//                 'type' => 'INT',
//                 'constraint' => 11,
//                 'unsigned' => true,
//                 'auto_increment' => true,
//             ],
//             'packinglistsize_pl_id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//             ],
//             'packinglistsize_size_id' => [
//                 'type' => 'BIGINT',
//                 'unsigned' => true,
//             ],
//             'packinglistsize_qty' => [
//                 'type' => 'INT',
//                 'constraint' => 11,
//                 'unsigned' => true,
//             ],
//             'packinglistsize_amount' => [
//                 'type' => 'INT',
//                 'constraint' => 11,
//                 'unsigned' => true,
//             ],
//             'created_at' => [
//                 'type' => 'DATETIME',
//                 'null' => true,
//             ],
//             'updated_at' => [
//                 'type' => 'DATETIME',
//                 'null' => true,
//             ],
//         ]);
//         $this->forge->addKey('id', true);
//         $this->forge->addForeignKey('packinglistsize_pl_id', 'tblpackinglist', 'id', 'CASCADE', 'CASCADE');
//         $this->forge->addForeignKey('packinglistsize_size_id', 'tblsizes', 'id', 'CASCADE', 'CASCADE');
//         $this->forge->createTable('tblpackinglistsizes');
//     }

//     public function down()
//     {
//         $this->forge->dropTable('tblpackinglistsizes');
//     }
// }

    public function detail($packinglist_no)
    {
        $data = [
            'title' => 'Factory Packing List',
            'pl' => $this->pl->select('tblpackinglist.*')
                ->where('tblpackinglist.packinglist_no', $packinglist_no)
                ->first(),
            'plsizes' => $this->plsize->select('tblpackinglistsizes.*, tblsizes.size')
                ->join('tblsizes', 'tblsizes.id = tblpackinglistsizes.packinglistsize_size_id')
                ->where('tblpackinglistsizes.packinglistsize_pl_id', $this->pl->select('tblpackinglist.id')
                    ->where('tblpackinglist.packinglist_no', $packinglist_no)
                    ->first()['id'])
                ->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pl/detail', $data);
    }
}
