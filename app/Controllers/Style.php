<?php

namespace App\Controllers;

use Config\Services;
use App\Models\StyleModel;

class Style extends BaseController
{
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title' => 'List of Styling',
            'styles' => $this->StyleModel->getStyle()->getResult()
        ];
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('style/index', $data);
    }

    public function save()
    {
        $this->StyleModel->save([
            'style_no'              => $this->request->getVar('number'),
            'style_description'     => $this->request->getVar('description')
        ]);

        session()->setFlashdata('pesan', 'Data Saved');
        return redirect()->to('style');
    }
    public function update()
    {
        $id = $this->request->getVar('edit_style_id');
        $data = array(
            'style_no'          => $this->request->getVar('number'),
            'style_description' => $this->request->getVar('description'),
        );
        $this->StyleModel->updateStyle($data, $id);
        return redirect()->to('/style');
    }

    public function delete()
    {
        $id = $this->request->getVar('style_id');
        $this->StyleModel->deleteStyle($id);
        return redirect()->to('style');
    }
}
