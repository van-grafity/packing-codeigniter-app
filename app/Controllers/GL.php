<?php

namespace App\Controllers;

use App\Models\BuyerModel;
use App\Models\GlModel;
use App\Models\StyleModel;

class GL extends BaseController
{
    protected $BuyerModel;
    protected $glModel;
    protected $StyleModel;

    public function __construct()
    {
        $this->glModel = new GlModel();
        $this->BuyerModel = new BuyerModel();
        $this->StyleModel = new StyleModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'List of GL',
            'gl'        => $this->glModel->getGL()->getResult(),
            'buyer'     => $this->BuyerModel->getBuyer()->getResult(),
            'style'     => $this->StyleModel->getStyles()->getResult(),
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
            'buyer_id'      => $this->request->getVar('gl_buyer'),
            'style_id'      => $this->request->getVar('gl_style'),
            'season'        => $this->request->getVar('season'),
            'size_order'    => $this->request->getVar('size_order'),
        );
        $this->glModel->saveGl($data);
        return redirect()->to('/gl');
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $data = array(
            'id'             => $this->request->getVar('id'),
            'gl_number'     => $this->request->getVar('number'),
            'season'        => $this->request->getVar('season'),
            'buyer_id'      => $this->request->getVar('gl_buyer'),
            'style_id'      => $this->request->getVar('gl_style'),
            'size_order'    => $this->request->getVar('size_order'),
        );
        $this->glModel->updateGL($data, $id);
        return redirect()->to('/gl');
    }
    public function delete()
    {
        $id = $this->request->getVar('glid');
        $this->glModel->deleteGL($id);
        return redirect()->to('gl');
    }
}
