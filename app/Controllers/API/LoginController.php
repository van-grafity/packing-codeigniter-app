<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Controllers\API\PalletTransferController;

use CodeIgniter\I18n\Time;

class LoginController extends ResourceController
{
    use ResponseTrait;

    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->getUserByEmail($email);
        if(!$user) {
            $data_return = [
                'status' => 'error',
                'message' => 'Email not found',
            ];
            return $this->respond($data_return);
        }
        if (!password_verify($password, $user['password_hash'])) {
            $data_return = [
                'status' => 'error',
                'message' => 'Wrong Password',
            ];
            return $this->respond($data_return);
        }

        $user_profile = $this->UserModel->getProfile($user['id']);
        $data_return = [
            'status' => 'success',
            'message' => 'Successfully Login',
            'data' => [
                'user' => $user_profile,
            ],
        ];
        return $this->respond($data_return);
    }

    public function getUserByEmail($email)
    {
        $UserModel = model('UserModel');
        return $UserModel->where('email', $email)->first();
    }

}
