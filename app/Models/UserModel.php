<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tblusers';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'name', 'firstname', 'lastname', 'email', 'new_email', 'password', 'password_confirm',
        'activate_hash', 'reset_hash', 'reset_expires', 'active','role_id'
    ];

    // Dates
    protected $useTimestamps = true;

    // Validation
    protected $validationRules      = [];

    // we use different rules for registration, account update, etc
    protected $dynamicRules      = [
        'registration' => [
            'firstname'         => 'required|alpha_space|min_length[2]',
            'lastname'          => 'required|alpha_space|min_length[2]',
            'name'              => 'required|alpha_space|min_length[2]',
            'email'             => 'required|valid_email|is_unique[tblusers.email,id,{id}]',
            'password'          => 'required|min_length[5]',
            'password_confirm'  => 'matches[password]',
            'role'              => 'required',
        ],
        'updateAccount' => [
            'id'                => 'required|is_natural',
            'name'              => 'required|alpha_space|min_length[2]'
        ],
        'updateProfile' => [
            'id'                => 'required|is_natural',
            'name'              => 'required|alpha_space|min_length[2]',
            'firstname'         => 'required|alpha_space|min_length[2]',
            'lastname'          => 'required|alpha_space|min_length[2]',
            'email'             => 'required|valid_email|is_unique[tblusers.email,id,{id}]',
            'role'              => 'required',
        ],
        'changeEmail' => [
            'id'                => 'required|is_natural',
            'new_email'         => 'required|valid_email|is_unique[tblusers.email]',
            'activate_hash'     => 'required'
        ],
        'enableuser' => [
            'id'    => 'required|is_natural',
            'active'    => 'required|integer'
        ]
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    // this runs after field validation
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Retrieves validation rule
     */
    public function getRule(string $rule)
    {
        return $this->dynamicRules[$rule];
    }

    /**
     * Hashes the password after field validation and before insert/update
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        unset($data['data']['password']);
        unset($data['data']['password_confirm']);

        return $data;
    }

    public function deleteUser($id)
    {
        $query = $this->db->table('tblusers')->delete(array('id' => $id));
        return $query;
    }

    public function getData()
    {
        $builder = $this->db->table('tblusers user');
        $builder->select('user.*, role.role');
        $builder->join('tblrole as role', 'role.id = user.role_id','LEFT');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProfile($user_id)
    {
        $builder = $this;
        $builder->join('tblrole as role', 'role.id = tblusers.role_id','LEFT');
        $builder->where('tblusers.id', $user_id);
        $builder->select('tblusers.id, tblusers.name, tblusers.email, tblusers.firstname, tblusers.lastname, role.role');
        $result = $builder->first();
        return $result;
    }
}