<?php

namespace App\Controllers;

use App\Models\GlModel;

class GL extends BaseController
{
    protected $glModel;

    public function __construct()
    {
        $this->glModel = new GlModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'List of GL',
            'gl'        => $this->glModel->getGL()->getResult(),
            'buyer'     => $this->glModel->getBuyer()->getResult(),
        ];

        // $glku = $this->glModel->getGL()->getResult();
        // dd($glku);
        return view('gl/index', $data);
    }

    public function save()
    {
        $data = array(
            'id'            => $this->request->getVar('id'),
            'gl_number'     => $this->request->getVar('number'),
            'season'        => $this->request->getVar('description'),
            'style_id'      => $this->request->getVar('description'),
            'buyer_id'      => $this->request->getVar('description'),
            'size_order'    => $this->request->getVar('description'),
        );
        $this->glModel->saveStyle($data);
        return redirect()->to('/gl');
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $data = array(
            'id'                => $this->request->getVar('id'),
            'gl_number'     => $this->request->getVar('number'),
            'season'        => $this->request->getVar('description'),
            'style_id'      => $this->request->getVar('description'),
            'buyer_id'      => $this->request->getVar('description'),
            'size_order'    => $this->request->getVar('description'),
        );
        $this->glModel->updateStyle($data, $id);
        return redirect()->to('/gl');
    }
    public function delete()
    {
        $id = $this->request->getVar('gl_id');
        $this->glModel->deleteGL($id);
        return redirect()->to('gl');
    }
}
