<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use CodeIgniter\Controller;

class ArticleController extends Controller
{
    public function list()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $articleModel = new ArticleModel();

        
        $perPage = 10; // Number of entries per page

        // Search functionality
        $search = $this->request->getGet('search');
        if ($search) {
            $articleModel->groupStart()   // applied 'or' condition for the searching 
                ->like('full_name', $search)
                ->orLike('phone_number', $search)
                ->orLike('email_address', $search)
                ->groupEnd();  // here the group ends 
        }

        // Fetch paginated results
        $data['article'] = $articleModel->where('status !=', 0)
                                        ->paginate($perPage); //it  Automatically handles the current page

        $data['pager'] = $articleModel->pager;
        $data['search'] = $search;

        return view('articles/list', $data);
    }
    public function form($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $articleModel = new ArticleModel();
        $data['article'] = $id ? $articleModel->find($id) : null;

        return view('articles/form', $data);
    }

    public function save()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'full_name' => 'required|min_length[3]|max_length[255]',
            'phone_number' => 'required|max_length[15]',
            'email_address' => 'required|valid_email|max_length[255]',
            'userid'=> 'max_length[11]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $articleModel = new ArticleModel();
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email_address' => $this->request->getPost('email_address'),
            'user_id' => $this->request->getPost('user_id'),
                 
        ];

        if ($this->request->getPost('id')) {
            $articleModel->update($this->request->getPost('id'), $data);
        } else {
            $articleModel->insert($data);
        }

        return redirect()->to('/articles/list')->with('success', 'Article saved successfully.');
    }

    
    public function delete($id)
    {
        $articleModel = new ArticleModel();

       
        $articleModel->update($id, ['status' => 1]);

        return redirect()->to('/articles/list')->with('success', 'Article status updated to deleted.');
    }
}
