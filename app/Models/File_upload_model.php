<?php

namespace App\Models;

use CodeIgniter\Model;

class File_upload_model extends Model
{
    protected $table = 'uploaded_files';

    protected $allowedFields = ['file_name', 'file_type', 'file_path', 'file_size'];

  
}

