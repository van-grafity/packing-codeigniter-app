<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UpdateDatabaseModel;


class UpdateDatabase extends BaseController
{
    protected $UpdateDatabaseModel;

    public function __construct()
    {
        $this->UpdateDatabaseModel = new UpdateDatabaseModel();
    }
    public function index()
    {
        $data_return = [
            [
                'title' => 'Update UPC product for AERO Intenational',
                'description' => 'Angka 00 yang ada di depan di hilangkan. lalu di akhir ditambahkan angka 124',
                'url' => base_url('update-database/aero-international-upc')
            ]
        ];
        return $this->response->setJSON($data_return);
    }

    public function aero_international_upc()
    {
        $gl_number = $this->request->getGet('gl_number');
        if(!$gl_number) {
            $result = [
                'status' => 'error',
                'message' => 'please input gl number in parameter'
            ];
            return $this->response->setJSON($result);
        }
        
        $po_list = $this->UpdateDatabaseModel->get_po_by_gl($gl_number);
        $new_product_list = array();
        $new_product_list_updated = array();
        foreach ($po_list as $key_po => $po) {
            $product_list = $this->UpdateDatabaseModel->get_product_by_po($po->po_id);
            foreach ($product_list as $key_product => $product) {
                $product = [
                    'id' => $product->product_id,
                    'product_code' =>($this->adjust_with_pattern($product->product_code))
                ];
                $new_product_list[] = $product;
            }
        }
        foreach ($new_product_list as $key_product_new => $product) {
            $new_product_list_updated[] = $this->UpdateDatabaseModel->update_product_code($product['id'], $product['product_code']);
        }

        $result = [
            'status' => 'success',
            'message' => 'Success update '.count($new_product_list_updated).' product code on detail PO',
            'data' => $new_product_list_updated, 
        ];
        return $this->response->setJSON($result);
    }

    private function adjust_with_pattern($product_code)
    {
        $pattern = '/^00/';
        if(preg_match($pattern, $product_code)){
            return preg_replace($pattern, '', $product_code).'124';
        } else {
            return $product_code;
        }
    }
}
