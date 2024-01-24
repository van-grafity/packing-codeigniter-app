<?php
namespace App\Libraries;

class ApiAuth
{
    public function login($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            return true;
        }
        return false;
    }

    public function getUserByEmail($email)
    {
        $UserModel = model('UserModel');
        return $UserModel->where('email', $email)->first();
    }

    public function checkCredentials($headers)
    {
        if (isset($headers['Authorization'])) {
            list($type, $credentials) = explode(' ', $headers['Authorization']);
            list($username, $password) = explode(':', base64_decode($credentials));

            if ($this->login($username, $password)) {
                $data_return = [
                    'status' => 'success',
                    'message' => 'Authorized',
                    'status_code' => 200,
                ];
            } else {
                $data_return = [
                    'status' => 'error',
                    'message' => 'Invalid username or password',
                    'status_code' => 401,
                ];
            }
        } else {
            $data_return = [
                'status' => 'error',
                'message' => 'Authorization header is missing',
                'status_code' => 401,
            ];
        }
        return $data_return;
    }
}
