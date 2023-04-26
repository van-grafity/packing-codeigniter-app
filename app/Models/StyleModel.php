<?php

namespace App\Models;

use CodeIgniter\Model;

class StyleModel extends Model
{
    protected $useTimestamps    = true;
    protected $table    = 'tblstyles';
    protected $allowedFields    = ['style_no', 'style_description', 'style_gl_id'];
    
}
