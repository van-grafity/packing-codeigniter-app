<?php

namespace App\Controllers;

use App\Models\ColourModel;

class Colour extends BaseController
{
    protected $ColourModel;

    public function __construct()
    {
        $this->ColourModel = new ColourModel();
    }

    public function index()
    {
        $data = [
            'title' => "List of Colour",
            'colour' => $this->ColourModel->getColour()->getResult()
        ];
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
            'id'                => $this->request->getVar('id'),
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
