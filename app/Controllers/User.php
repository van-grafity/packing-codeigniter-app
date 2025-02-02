<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\UserModel;
use App\Models\LogsModel;
use App\Models\RoleModel;

class User extends BaseController
{
    protected $UserModel;
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

    public function index()
    {
        // current year and month variable
        $ym = date("Y-m");

        // load user model
        $users = new UserModel();

        // getall users
        $allusers = $users->getData();

        // count all rows in tbluser table
        $countusers = $users->countAll();

        // count all active user in the last 30 days
        $newusers = $users->like("created_at", $ym)->countAllResults();

        // count all active users
        $activeusers = $users->where('active', 1)->countAllResults();

        // calculate active users in how many percents
        $percentofactiveusers = ($activeusers / $countusers) * 100;


        $roles = new RoleModel();
        $roles = $roles->findAll();


        // load the view with session data
        return view('user/index', [
            'title' => 'User Management',
            'card_title' => 'List of User',
            'userData' => $this->session->userData,
            'data' => $allusers,
            'usercount' => $countusers,
            'newusers' => $newusers,
            'percentofactiveusers' => $percentofactiveusers,
            'roles' => $roles,
        ]);

        // check if user is signed-in if not redirect to login page
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
    }

    public function createUser()
    {
        // dd($this->request->getVar());
        
        helper('text');

        // save new user, validation happens in the model
        $users = new UserModel();
        $getRule = $users->getRule('registration');
        $users->setValidationRules($getRule);

        $user = [
            'firstname'     => $this->request->getPost('firstname'),
            'lastname'      => $this->request->getPost('lastname'),
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'role_id'       => $this->request->getPost('role'),
            'role'          => $this->request->getPost('role'),
            'password'      => $this->request->getPost('password'),
            'password_confirm'  => $this->request->getPost('password_confirm'),
            'activate_hash'     => random_string('alnum', 32)
        ];

        if (!$users->insert($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect()->back()->with('success', 'Success! You created a new account');
    }

    public function enable($id = null)
    {
        $users = new UserModel();
        $user = [
            'id'      => $id,
            'active'      => 1,
        ];
        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect()->back()->with('success', "User successfully activated");
    }
    
    public function disable($id)
    {
        $users = new UserModel();
        $user = [
            'id'      => $id,
            'active'      => 0,
        ];
        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect()->back()->with('success', "User successfully deativated");

    }

    public function edit()
    {
        // get the user id
        $id = $this->request->uri->getSegment(3);

        // load user model
        $users = new UserModel();

        // get user data using the id
        $user = $users->where('id', $id)->first();

        // load the view with session data
        return view('user/edit-user', [
            'title' => "Edit User",
            'userData' => $this->session->userData,
            'user' => $user,
        ]);
    }

    public function update()
    {
        // dd($this->request->getVar());
        
        // edit existing user, validation happens in the model
        $users = new UserModel();
        $getRule = $users->getRule('updateProfile');
        $users->setValidationRules($getRule);

        $user = [
            'id'        => $this->request->getPost('id'),
            'name'      => $this->request->getPost('name'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'role_id'   => $this->request->getPost('role'),
        ];

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect('user')->with('success', 'The account successfully updated!');
    }

    public function delete()
    {
        $users = new UserModel();

        $id = $this->request->getVar('user_id');
        $users->deleteUser($id);

        if (!$users->deleteUser($id)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        return redirect('user')->with('success', 'The account successfully deleted!');
    }
}
