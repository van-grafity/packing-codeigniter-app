<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\UserModel;
use App\Models\LogsModel;

class Users extends BaseController
{
    /**
     * Access to current session.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Authentication settings.
     */
    protected $config;

    public function __construct()
    {
        // start session
        $this->session = Services::session();
    }

    public function user()
    {
        // current year and month variable
        $ym = date("Y-m");

        // load user model
        $users = new UserModel();

        // getall users
        $allusers = $users->findAll();

        // count all rows in tbluser table
        $countusers = $users->countAll();

        // count all active user in the last 30 days
        $newusers = $users->like("created_at", $ym)->countAllResults();

        // count all active users
        $activeusers = $users->where('active', 1)->countAllResults();

        // calculate active users in how many percents
        $percentofactiveusers = ($activeusers / $countusers) * 100;

        // load the view with session data
        return view('user/users', [
            'title' => 'User Management',
            'userData' => $this->session->userData,
            'data' => $allusers,
            'usercount' => $countusers,
            'newusers' => $newusers,
            'percentofactiveusers' => $percentofactiveusers
        ]);

        // check if user is signed-in if not redirect to login page
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
    }

    public function createUser()
    {
        helper('text');

        // save new user, validation happens in the model
        $users = new UserModel();
        $getRule = $users->getRule('registration');
        $users->setValidationRules($getRule);

        $user = [
            'firstname'              => $this->request->getPost('firstname'),
            'lastname'              => $this->request->getPost('lastname'),
            'name'              => $this->request->getPost('name'),
            'email'             => $this->request->getPost('email'),
            'password'             => $this->request->getPost('password'),
            'password_confirm'    => $this->request->getPost('password_confirm'),
            'activate_hash'     => random_string('alnum', 32)
        ];
        // dd($users->test_model());
        if (!$users->insert($user)) {
            // dd($users);
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // send activation email //
        // send email activation is commented no email support //

        // helper('auth'); 
        // send_activation_email($user['email'], $user['activate_hash']);

        // success
        return redirect()->back()->with('success', 'Success! You created a new account');
    }
}
