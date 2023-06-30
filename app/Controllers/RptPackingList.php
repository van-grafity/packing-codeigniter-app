<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RptPackingList extends BaseController
{
    public function index()
    {
        $data = [
            'title'  => 'Packing List',
        ];

        return view('report/packinglist', $data);
    }
}
