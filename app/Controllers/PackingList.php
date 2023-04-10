<?php

namespace App\Controllers;

class PackingList extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Packing List'
        ];
        return view('pl/index', $data);
    }
}
