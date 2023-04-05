<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'User List'
        ];
        return view('user/index', $data);
    }
}
