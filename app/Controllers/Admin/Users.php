<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index()
    {
        //echo 'Ini adalah CONTROLLER Users method index yang ada di dalam folder Admin';
        $data = [
            'title' => 'Users Administration',
            'subtitle' => 'List of Users'
        ];
        return view('admin/users', $data);
    }
}
