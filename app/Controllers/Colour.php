<?php

namespace App\Controllers;

use Config\Services;
use App\Models\ColourModel;

class Colour extends BaseController
{
    protected $ColourModel;
    protected $session;

    public function __construct()
    {
        $this->ColourModel = new ColourModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title' => "List of Colour",
            'colour' => $this->ColourModel->getColour()->getResult()
        ];
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('colour/index', $data);
    }

    public function save()
    {
        $data = array(
            'colour_name'  => $this->request->getVar('name'),
        );
        $this->ColourModel->save($data);
        return redirect()->to('colour')->with('success', "Successfully added Colour");
        // return redirect()->to('lines')->with('success', 'Successfully added Line');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_colour_id');
        $data = array(
            'colour_name'          => $this->request->getVar('name'),
        );

        $this->ColourModel->updateColour($data, $id);
        return redirect()->to('/colour');
    }

    public function delete()
    {
        $id = $this->request->getVar('colour_id');
        $this->ColourModel->deleteColour($id);
        return redirect()->to('colour');
    }
}
