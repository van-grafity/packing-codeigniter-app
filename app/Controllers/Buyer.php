<?php

namespace App\Controllers;

use App\Models\BuyerModel;

class Buyer extends BaseController
{
    protected $buyerModel;
    protected $helpers = ['number', 'form'];

    public function __construct()
    {
        $this->buyerModel = new BuyerModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Buyer List',
            'buyer'  => $this->buyerModel->getBuyer()->getResult()
        ];

        return view('buyer/index', $data);
    }

    public function check()
    {
        $rules = [
            'name' => 'required|is_unique',
            'offadd' => 'required',
            'shipadd' => 'required'
        ];

        if ($this->validate($rules)) {
            $data = [
                'name'      => $this->request->getvar('name'),
                'offadd'    => $this->request->getvar('offadd'),
                'shipadd'   => $this->request->getvar('shipadd'),
                'country'   => $this->request->getvar('country'),
            ];
            $this->buyerModel->save($data);
            return redirect()->to('buyer');
        } else {
            $data['validation'] = $this->validator;
            return view('buyer', $data);
        }
    }

    public function save()
    {
        // $code = url_title($this->request->getVar('name'), '-', true);

        $this->buyerModel->save([
            'buyer_name' => $this->request->getVar('name'),
            'offadd' => $this->request->getVar('offadd'),
            'shipadd' => $this->request->getVar('shipadd'),
            'country' => $this->request->getVar('country')
        ]);

        session()->setFlashdata('pesan', 'Data Saved');
        return redirect()->to('buyer');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_buyer_id');

        $data = array(
            'buyer_name'    => $this->request->getVar('name'),
            'offadd'        => $this->request->getVar('offadd'),
            'shipadd'       => $this->request->getVar('shipadd'),
            'country' => $this->request->getVar('country'),
        );
        // dd($this->request->getvar());
        $this->buyerModel->updateBuyer($data, $id);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('buyer');
    }

    public function delete()
    {
        $id = $this->request->getVar('buyer_id');
        $this->buyerModel->deleteBuyer($id);
        return redirect()->to('/buyer');
    }
}
