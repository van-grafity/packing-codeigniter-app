<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'List of Category',
            'category' => $this->CategoryModel->getCategory()->getResult()
        ];
        return view('category/index', $data);
    }

    public function save()
    {
        $data = array(
            'category_name'          => $this->request->getVar('name'),
        );
        $this->CategoryModel->saveCategory($data);
        return redirect()->to('/category');
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $data = array(
            'id'                => $this->request->getVar('id'),
            'category_name'          => $this->request->getVar('name'),
        );
        $this->CategoryModel->updateCategory($data, $id);
        return redirect()->to('/category');
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        $this->CategoryModel->deleteCategory($id);
        return redirect()->to('category');
    }
}