<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'SCAN & PACK SYSTEM',
            'msg1'  => 'An Application for Shipping Department',
            'msg2'  => '',
            'msg3'  => 'PT. Ghim Li Indonesia'
        ];

        return view('app-layout/dashboard', $data);
    }
}
