<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\File_upload_model;

class FileUploadController extends BaseController
{
    protected $fileModel;  // Corrected variable name to match usage

    public function __construct()
    {
        // Initialize the FileModel in the constructor
        $this->fileModel = new File_upload_model();
    }

    public function index()
    {
        // Display the upload form
        return view('upload_form');
    }

    public function uploadFile()
    {
        // Initialize validation service
        $validation = \Config\Services::validation();

        // Set validation rules for the file input
        $validation->setRules([
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/png,image/gif]|max_size[file,2048]',
                'errors' => [
                    'uploaded' => 'No file selected',
                    'mime_in' => 'Invalid file type. Only images are allowed.',
                    'max_size' => 'File size exceeds 2MB.'
                ]
            ]
        ]);

        // If validation fails, return to the form with validation errors
        if (!$validation->withRequest($this->request)->run()) {
            return view('upload_form', ['validation' => $validation]);
        }

        // Get the uploaded file
        $file = $this->request->getFile('file');

        // Check if the file is valid and hasn't been moved
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate a random name for the file
            $newFileName = $file->getRandomName();
            
            // Move the file to the uploads directory
            if ($file->move(WRITEPATH . 'uploads', $newFileName)) {
                // Prepare file data for the database
                $data = [
                    'file_name' => $newFileName,
                    'file_type' => $file->getClientMimeType(),
                    'file_path' => 'uploads/' . $newFileName,  // Relative path
                    'file_size' => $file->getSize(),
                ];

                // Debug log: check the file data before inserting into the database
                log_message('info', 'File data: ' . json_encode($data));

                // Insert file data into the database and check for success
                if ($this->fileModel->insert($data)) {
                    $message = "File successfully uploaded and saved in the database!";
                } else {
                    // If insert fails, log the errors and display them
                    log_message('error', 'Model Insert Errors: ' . json_encode($this->fileModel->errors()));
                    $message = "File upload failed: " . implode(', ', $this->fileModel->errors());
                }
            } else {
                // Log and display file move error
                log_message('error', 'File move failed: ' . $file->getErrorString());
                $message = "File move failed: " . $file->getErrorString();
            }

            // Return to the form with a success or failure message
            return view('upload_form', ['message' => $message]);
        }

        // If the file is invalid, return with a failure message
        $message = "File upload failed.";
        return view('upload_form', ['message' => $message]);
    }
}
