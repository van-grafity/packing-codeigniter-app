<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Demo extends BaseController
{
    public function __construct()
    {
        helper(['url']);
    }

    public function index()
    {
        return view('demo/index');
    }

    public function ajax()
    {
        $term = $this->request->getVar('term');
        $ProdukModel = new ProdukModel();
        $names = $ProdukModel->like('product_code', $term, 'both')->findColumn('product_code');
        return $this->response->setJSON($names);
    }
}
