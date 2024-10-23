<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_name', 'father_name', 'mother_name', 'class', 
        'gender', 'photo', 'registration_no', 'section'
    ];

  
}
