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
            'title' => 'List of Product Type',
            'category' => $this->CategoryModel->getCategory()->getResult()
        ];
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
