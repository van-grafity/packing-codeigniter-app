<?php

namespace App\Controllers;

use Config\Services;
use App\Models\FactoryModel;

class Factory extends BaseController
{
    protected $FactoryModel;
    protected $session;

    public function __construct()
    {
        $this->FactoryModel = new FactoryModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title'     => 'Factory List',
            'factory'   => $this->FactoryModel->getFactory()->getResult()
        ];
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('factory/index', $data);
    }

    public function save()
    {
        $data = array(
            'id'        => $this->request->getVar('id'),
            'name'      => $this->request->getVar('name'),
            'incharge'  => $this->request->getVar('incharge'),
            'remarks'   => $this->request->getVar('remarks'),
        );
        $this->FactoryModel->save($data);
        return redirect()->to('/factory');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_factory_id');

        $data = array(
            'name'      => $this->request->getVar('name'),
            'incharge'  => $this->request->getVar('incharge'),
            'remarks'   => $this->request->getVar('remarks'),
        );
        $this->FactoryModel->updateFactory($data, $id);
        return redirect()->to('/factory');
    }

    public function delete()
    {
        $id = $this->request->getVar('factory_id');
        $this->FactoryModel->deleteFactory($id);
        return redirect()->to('factory');
    }
}
