<?php

namespace App\Controllers;

use Config\Services;
use App\Models\BuyerModel;
use App\Models\GlModel;
use App\Models\StyleModel;

class Gl extends BaseController
{
    protected $BuyerModel;
    protected $GlModel;
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->GlModel = new GlModel();
        $this->BuyerModel = new BuyerModel();
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $gl_list = $this->GlModel->getGL()->getResult();
        foreach ($gl_list as $key => $gl) {
            $style_by_gl = $this->StyleModel->getStyleByGL($gl->id);
            $gl_list[$key]->style_no = implode(' | ', (array_column($style_by_gl, 'style_no')));
        }
        $data = [
            'title'     => 'List of GL',
            'gl'        => $gl_list,
            'buyer'     => $this->BuyerModel->getBuyer()->getResult(),
        ];
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
        $this->GlModel->save($data);
        return redirect()->to('/gl');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_gl_id');
        $data = array(
            'gl_number'     => $this->request->getVar('number'),
            'season'        => $this->request->getVar('season'),
            'buyer_id'      => $this->request->getVar('gl_buyer'),
            'style_id'      => $this->request->getVar('gl_style'),
            'size_order'    => $this->request->getVar('size_order'),
        );
        $this->GlModel->update($id, $data);
        return redirect()->to('gl');
    }
    public function delete()
    {
        $id = $this->request->getVar('gl_id');
        $this->GlModel->delete($id);
        return redirect()->to('gl');
    }
}
