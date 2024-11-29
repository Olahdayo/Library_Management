<?php
require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/helpers/Session.php';
require_once dirname(__DIR__) . '/models/User.php';

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $db = new Database();
        $this->userModel = new User($db->connect());
    }

    public function login()
    {
        if (Session::isLoggedIn()) {
            header('Location: ' . URL_ROOT . '/dashboard');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                return $this->view('auth/login', ['error' => 'Please fill in all fields']);
            }

            $user = $this->userModel->findUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['age'] = $user['age'];
                $_SESSION['prev_url'] = $_SERVER['REQUEST_URI'];

                header('Location: ' . URL_ROOT . '/dashboard');
                exit();
            } else {
                return $this->view('auth/login', ['error' => 'Invalid credentials']);
            }
        }

        // GET request - just show the form
        return $this->view('auth/login');
    }

    public function logout()
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        
        $_SESSION = [];

        $_SESSION['prev_url'] = $currentUrl;

        session_destroy();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        header('Location: ' . URL_ROOT . '/auth/login');
        exit();
    }

    public function signup()
    {
        if (Session::isLoggedIn()) {
            header('Location: ' . URL_ROOT . '/dashboard');
            exit();
        }

        $data = [
            'title' => 'Sign Up',
            'name' => '',
            'username' => '',
            'email' => '',
            'phone' => '',
            'age' => '',
            'gender' => '',
            'password' => '',
            'confirm_password' => '',
            'errors' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data using htmlspecialchars
            $data['name'] = htmlspecialchars(trim($_POST['name'] ?? ''));
            $data['username'] = htmlspecialchars(trim($_POST['username'] ?? ''));
            $data['email'] = htmlspecialchars(trim($_POST['email'] ?? ''));
            $data['phone'] = htmlspecialchars(trim($_POST['phone'] ?? ''));
            $data['age'] = htmlspecialchars(trim($_POST['age'] ?? ''));
            $data['gender'] = htmlspecialchars(trim($_POST['gender'] ?? ''));
            $data['password'] = trim($_POST['password'] ?? '');
            $data['confirm_password'] = trim($_POST['confirm_password'] ?? '');

            // Validate name
            if (empty($data['name'])) {
                $data['errors']['name'] = 'Please enter your full name';
            }

            // Validate username
            if (empty($data['username'])) {
                $data['errors']['username'] = 'Please enter a username';
            } elseif (strlen($data['username']) < 5) {
                $data['errors']['username'] = 'Username must be at least 5 characters';
            } elseif ($this->userModel->findUserByUsername($data['username'])) {
                $data['errors']['username'] = 'Username is already taken';
            } else {
                // Clear username error if validation passes
                unset($data['errors']['username']);
            }

            // Validate email
            if (empty($data['email'])) {
                $data['errors']['email'] = 'Please enter an email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Please enter a valid email';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['errors']['email'] = 'Email is already registered';
            }

            // Validate phone (11 digits)
            if (empty($data['phone'])) {
                $data['errors']['phone'] = 'Please enter a phone number';
            } elseif (!preg_match("/^[0-9]{11}$/", $data['phone'])) {
                $data['errors']['phone'] = 'Please enter a valid 11-digit phone number';
            }

            // Validate age
            if (empty($data['age'])) {
                $data['errors']['age'] = 'Please enter your age';
            } elseif (!is_numeric($data['age']) || $data['age'] < 16 || $data['age'] > 100) {
                $data['errors']['age'] = 'Age must be between 16 and 100';
            }

            // Validate gender
            if (empty($data['gender'])) {
                $data['errors']['gender'] = 'Please select your gender';
            } elseif (!in_array($data['gender'], ['male', 'female', 'other'])) {
                $data['errors']['gender'] = 'Invalid gender selection';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['errors']['password'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['errors']['confirm_password'] = 'Please confirm password';
            } elseif ($data['password'] != $data['confirm_password']) {
                $data['errors']['confirm_password'] = 'Passwords do not match';
            }

            // If no errors, register user
            if (empty($data['errors'])) {
                // Register user
                if ($this->userModel->register($data)) {
                    $_SESSION['registration_success'] = true;
                    $this->view('auth/registration-success');
                    exit();
                } else {
                    $data['errors']['general'] = 'Something went wrong. Please try again.';
                }
            }
        }

        require_once APP_PATH . '/views/auth/signup.php';
    }

    protected function view($view, $data = [])
    {
        extract($data);
        require_once APP_PATH . '/views/' . $view . '.php';
    }
}
