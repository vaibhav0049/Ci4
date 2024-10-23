<?php

namespace App\Controllers;

use App\Models\StudentModel;
use CodeIgniter\Controller;

class StudentUploadController extends Controller
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    // Render the form
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['student'] = $this->studentModel->find($id);
        }
        return view('student/form', $data);
    }

    // Upload the student data
    public function upload()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'student_name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'class' => 'required',
            'gender' => 'required',
            'registration_no' => 'required|is_unique[students.registration_no]',
            'photo' => 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,jpg,jpeg,png]',
            'section' => 'required'
        ]);

        if (!$this->validate($validation->getRules())) {
            return $this->response->setStatusCode(400)->setJSON(['errors' => $validation->getErrors()]);
        }

        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $photoName);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File upload failed']);
        }

        $studentData = [
            'student_name' => $this->request->getPost('student_name'),
            'father_name' => $this->request->getPost('father_name'),
            'mother_name' => $this->request->getPost('mother_name'),
            'class' => $this->request->getPost('class'),
            'gender' => $this->request->getPost('gender'),
            'photo' => $photoName,
            'registration_no' => $this->request->getPost('registration_no'),
            'section' => implode(', ', $this->request->getPost('section') ?? [])
        ];

        if ($this->studentModel->insert($studentData)) {
            return $this->response->setJSON(['success' => 'Student data saved successfully']);
        } else {
            log_message('error', 'Database Save Error: ' . json_encode($this->studentModel->errors()));
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to save data in the database']);
        }
    }
    public function list()
    {

        $perPage = 10;


        $search = $this->request->getGet('search');
        if ($search) {
            $this->studentModel->groupStart()   // applied 'or' condition for the searching 
                ->like('student_name', $search)
                ->orLike('registration_no', $search)
                ->orLike('father_name', $search)
                ->groupEnd();  // here the group ends 
        }
        $data['students'] = $this->studentModel
            ->paginate($perPage);

        $data['pager'] = $this->studentModel->pager;

        $data['search'] = $search;



        $data['student'] = $this->studentModel->findAll();
        return view('student/list', $data);
    }



    







    public function delete($id)
    {
        if ($this->studentModel->delete($id)) {
            return $this->response->setJSON(['success' => 'Student deleted successfully']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to delete student']);
        }
    }
}
