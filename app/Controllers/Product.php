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
            'category'  => $this->ProductModel->getCategory()->getResult(),
            'style'     => $this->ProductModel->getStyle()->getResult(),
        ];
        // $produk = $this->ProductModel->getProduct()->getResult();
        // dd($produk);
        return view('product/index', $data);
    }

    public function save()
    {
        $this->ProductModel->save(
            [
                'product_code'        => $this->request->getVar('product_code'),
                'product_asin_id'     => $this->request->getVar('product_asin_id'),
                'product_category_id' => $this->request->getVar('product_category'),
                'product_style_id'    => $this->request->getVar('product_Style'),
                'product_name'        => $this->request->getVar('product_name'),
                'product_price'       => $this->request->getVar('product_price')
            ]
        );
        session()->setFlashdata('pesan', ' Data Added');
        return redirect()->to('/product');
    }

    public function update()
    {
        $id = $this->request->getVar('product_id');
        $data = array(
            'product_code'        => $this->request->getVar('product_code'),
            'product_asin_id'     => $this->request->getVar('product_asin_id'),
            'product_category_id' => $this->request->getVar('product_category'),
            'product_style_id'    => $this->request->getVar('product_style'),
            'product_name'        => $this->request->getVar('product_name'),
            'product_price'       => $this->request->getVar('product_price'),
        );
        $this->ProductModel->updateProduct($data, $id);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('product');
    }

    public function delete()
    {
        $id = $this->request->getVar('product_id');
        $this->ProductModel->deleteProduct($id);
        return redirect()->to('/product');
    }
}
