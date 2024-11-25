<?php

class ProfileController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function edit() {
        // Get current user data
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $_SESSION['age'] = $user['age']; // Update session with current age
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $userData = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'age' => $_POST['age'],
                    'current_password' => $_POST['current_password'] ?? '',
                    'new_password' => $_POST['new_password'] ?? ''
                ];

                if ($this->userModel->updateUser($_SESSION['user_id'], $userData)) {
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['phone'] = $_POST['phone'];
                    $_SESSION['age'] = $_POST['age'];
                    
                    header('Location: ' . URL_ROOT . '/profile/edit?success=1');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . URL_ROOT . '/profile/edit');
                exit();
            }
        }
        
        $this->view('profile/edit');
    }

    private function view($path, $data = []) {
        require_once '../app/views/' . $path . '.php';
    }
} 