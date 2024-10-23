<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()   
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        
        $user = $userModel->where('username', $username)
                          ->where('password', $password)
                          ->first();

       
        log_message('debug', 'Username: ' . $username);
        log_message('debug', 'Password: ' . $password);
        log_message('debug', 'User Found: ' . print_r($user, true));

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid information');
        }

        session()->set(['user_id' => $user['id'], 'username' => $user['username'], 'isLoggedIn' => true]);
        return redirect()->to('/articles/list');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'You have been logged out.');
    }
}
