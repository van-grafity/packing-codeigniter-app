<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\StyleModel;

class Style extends BaseController
{
    public function __construct()
    {
        $this->styleModel = new StyleModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Style',
            'styles' => $this->styleModel->select('*')->join('tblgl', 'tblgl.id = tblstyles.style_gl_id')->get()->getResultArray(),
            'validation' => \Config\Services::validation()
        ];
        return view('style/index', $data);
    }
}
