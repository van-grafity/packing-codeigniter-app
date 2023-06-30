<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UserModel;
use App\Models\LogsModel;

class Login extends BaseController
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

    /**
     * Displays login form or redirects if user is already logged in.
     */
    public function index()
    {
        $data = [
            'title' => 'Please login into system.'
        ];

        if ($this->session->isLoggedIn) {
            return redirect()->to('home');
        }

        return view('auth/login', $data);
    }

    /**
     * Attempts to verify user's credentials through POST request.
     */
    public function attemptLogin()
    {
        // validate request
        $rules = [
            'email'        => 'required|valid_email',
            'password'     => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('login')->withInput()->with('errors', $this->validator->getErrors());
        }

        // check credentials
        $users = new UserModel();

        $user = $users->where('email', $this->request->getPost('email'))->first();
        if(!$user) {
            return redirect()->to('login')->withInput()->with('error', "Email not found.");
        }

        if (is_null($user) || !password_verify($this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->to('login')->withInput()->with('error', "Wrong Password!");
        }

        // check activation
        if (!$user['active']) {
            return redirect()->to('login')->withInput()->with('error', 'Your account is not active.');
        }

        // login OK, save user data to session
        $this->session->set('isLoggedIn', true);
        $this->session->set('role_id', $user["role_id"]);
        $this->session->set('userData', [
            'id'            => $user["id"],
            'name'          => $user["name"],
            'firstname'     => $user["firstname"],
            'lastname'      => $user["lastname"],
            'email'         => $user["email"],
            'new_email'     => $user["new_email"],
            'active'        => $user["active"]
        ]);

        // save login info to user login logs for tracking
        // get user agent
        $agent = $this->request->getUserAgent();
        // load logs model
        $logs = new LogsModel();
        // logs data
        $userlog = [
            'date'      => date("Y-m-d"),
            'time'      => date("H:i:s"),
            'reference' => $user["id"],
            'name'      => $user["name"],
            'ip'        => $this->request->getIPAddress(),
            'browser'   => $agent->getBrowser(),
            'status'    => 'Success'
        ];
        // logs to database
        $logs->save($userlog);

        return redirect()->to('home');
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
