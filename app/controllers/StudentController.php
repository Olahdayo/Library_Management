<?php

class StudentController extends Controller
{
    public function editProfile()
    {
        // Get current student's data
        $student = $this->model('Student')->find($_SESSION['student_id']);
        
        $this->view('students/edit-profile', [
            'student' => $student
        ]);
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                // add other fields
            ];

            // Update student
            if ($this->model('Student')->update($_SESSION['student_id'], $data)) {
                $_SESSION['message'] = 'Profile Updated Successfully';
                header('Location: /students/dashboard');
                exit();
            } else {
                $this->view('students/edit-profile', [
                    'student' => $data,
                    'error' => 'Something went wrong'
                ]);
            }
        }
    }
} 