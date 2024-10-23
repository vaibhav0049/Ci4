<?php

namespace App\Models;

use CodeIgniter\Model;



class ArticleModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'id';
    protected $allowedFields = ['full_name', 'phone_number', 'email_address','status'];
}
