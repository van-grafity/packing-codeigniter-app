<?php

namespace App\Controllers;

class Cartonbarcode extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Carton Barcode Setup'
        ];
        return view('carton/index', $data);
    }
}
