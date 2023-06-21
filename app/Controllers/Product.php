<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CategoryModel;
use App\Models\ColourModel;
use App\Models\ProductModel;
use App\Models\SizeModel;
use App\Models\StyleModel;
use Faker\Extension\Helper;

Helper('number');

class Product extends BaseController
{
    protected $CategoryModel;
    protected $ColourModel;
    protected $ProductModel;
    protected $SizeModel;
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
        $this->ColourModel = new ColourModel();
        $this->ProductModel = new ProductModel();
        $this->SizeModel = new SizeModel();
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title'     => 'Product List',
            'category'  => $this->CategoryModel->getCategory()->getResult(),
            'colour'    => $this->ColourModel->getColour()->getResult(),
            'product'   => $this->ProductModel->getProduct()->getResult(),
            'size'      => $this->SizeModel->getSize()->getResult(),
            'style'     => $this->StyleModel->getStyle()->getResult(),
        ];
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('product/index', $data);
    }

    public function save()
    {
        $this->ProductModel->save(
            [
                'product_code'        => $this->request->getVar('product_code'),
                'product_asin_id'     => $this->request->getVar('product_asin_id'),
                'product_category_id' => $this->request->getVar('product_category'),
                'product_style_id'    => $this->request->getVar('product_style_id'),
                'product_colour_id'    => $this->request->getVar('product_colour_id'),
                'product_size_id'    => $this->request->getVar('product_size_id'),
                'product_name'        => $this->request->getVar('product_name'),
                'product_price'       => $this->request->getVar('product_price')
            ]
        );
        session()->setFlashdata('pesan', ' Data Added');
        return redirect()->to('/product');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_product_id');
        $data = array(
            'product_code'        => $this->request->getVar('product_code'),
            'product_asin_id'     => $this->request->getVar('product_asin_id'),
            'product_category_id' => $this->request->getVar('product_category'),
            'product_style_id'    => $this->request->getVar('product_style_id'),
            'product_colour_id'    => $this->request->getVar('product_colour_id'),
            'product_size_id'    => $this->request->getVar('product_size_id'),
            'product_name'        => $this->request->getVar('product_name'),
            'product_price'       => $this->request->getVar('product_price'),
        );
        // dd($id);
        $this->ProductModel->updateProduct($data, $id);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('product');
    }

    public function delete()
    {

        $id = $this->request->getVar('product_id');
        // dd($id);
        $this->ProductModel->deleteProduct($id);
        return redirect()->to('/product');
    }
}
