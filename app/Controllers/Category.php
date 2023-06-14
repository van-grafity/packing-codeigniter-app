<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $CategoryModel;
    protected $session;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title' => 'List of Product Type',
            'category' => $this->CategoryModel->getCategory()->getResult()
        ];

        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('category/index', $data);
    }

    public function save()
    {
        $data = array(
            'category_name'          => $this->request->getVar('name'),
        );
        $this->CategoryModel->save($data);
        return redirect()->to('/category');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_category_id');
        $data = array(
            'id'                => $this->request->getVar('id'),
            'category_name'          => $this->request->getVar('name'),
        );
        $this->CategoryModel->updateCategory($data, $id);
        return redirect()->to('/category');
    }

    public function delete()
    {
        $id = $this->request->getVar('category_id');
        $this->CategoryModel->deleteCategory($id);
        return redirect()->to('category');
    }
}
