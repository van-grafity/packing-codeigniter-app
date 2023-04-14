<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PackingList extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Factory Packing List',
            'menu' => 'packinglist',
            'submenu' => 'packinglist',
            'content' => 'pl/index',
        ];
        return view('pl/index', $data);
    }
}
