<?php

namespace App\Models;

use CodeIgniter\Model;

class FactoryModel extends Model
{
    protected $table            = 'tblfactory';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'incharge',
        'remarks',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = 
    [
        'name' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'incharge' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'remarks' => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Factory name is required',
            'alpha_numeric_space' => 'Factory name must contain only alphanumeric characters and spaces',
            'min_length' => 'Factory name must be at least 3 characters in length',
            'max_length' => 'Factory name must not exceed 100 characters in length',
        ],
        'incharge' => [
            'required' => 'Factory incharge is required',
            'alpha_numeric_space' => 'Factory incharge must contain only alphanumeric characters and spaces',
            'min_length' => 'Factory incharge must be at least 3 characters in length',
            'max_length' => 'Factory incharge must not exceed 50 characters in length',
        ],
        'remarks' => [
            'required' => 'Factory remarks is required',
            'alpha_numeric_space' => 'Factory remarks must contain only alphanumeric characters and spaces',
            'min_length' => 'Factory remarks must be at least 3 characters in length',
            'max_length' => 'Factory remarks must not exceed 255 characters in length',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
