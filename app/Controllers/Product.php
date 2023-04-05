<?php

namespace App\Controllers;

use App\Models\ProductModel;

helper('number');

class Product extends BaseController
{
    protected $ProductModel;

    public function __construct()
    {
        $this->ProductModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Product List',
            'product'   => $this->ProductModel->getProduct()->getResult(),
            'category'  => $this->ProductModel->getCategory()->getResult()
        ];
        return view('product/index', $data);
    }

    public function save()
    {
        $model = new ProductModel();
        $data = array(
            'product_code'        => $this->request->getPost('product_code'),
            'product_asin_id'     => $this->request->getPost('product_asin_id'),
            'style'               => $this->request->getPost('style'),
            'product_name'        => $this->request->getPost('product_name'),
            'product_price'       => $this->request->getPost('product_price'),
            'product_category_id' => $this->request->getPost('product_category'),
        );
        $model->saveProduct($data);
        return redirect()->to('/product');
    }

    public function update()
    {
        $model = new ProductModel();
        $id = $this->request->getPost('product_id');
        $data = array(
            'product_code'        => $this->request->getPost('product_code'),
            'product_asin_id'     => $this->request->getPost('product_asin_id'),
            'style'               => $this->request->getPost('style'),
            'product_name'        => $this->request->getPost('product_name'),
            'product_price'       => $this->request->getPost('product_price'),
            'product_category_id' => $this->request->getPost('product_category'),
        );
        $model->updateProduct($data, $id);
        return redirect()->to('/product');
    }

    public function delete()
    {
        $model = new ProductModel();
        $id = $this->request->getPost('product_id');
        $model->deleteProduct($id);
        return redirect()->to('/product');
    }
}
