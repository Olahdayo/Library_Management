<?php
require_once dirname(__DIR__) . '/models/Book.php';
require_once dirname(__DIR__) . '/models/User.php';

class AdminController extends Controller
{
    private $bookModel;
    private $userModel;

    public function __construct($db)
    {
        // Check if user is admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit();
        }

        $this->bookModel = new Book($db);
        $this->userModel = new User($db);
    }

    public function dashboard()
    {
        $totalStudents = $this->userModel->getTotalStudents();
        $totalBooks = $this->bookModel->getTotalBooks();
        $activeBorrows = $this->bookModel->getActiveBorrowsCount();
        $overdueBorrows = $this->bookModel->getOverdueBorrowsCount();
        $recentBorrows = $this->bookModel->getActiveBorrows();
        
        $viewData = [
            'totalStudents' => $totalStudents,
            'totalBooks' => $totalBooks,
            'activeBorrows' => $activeBorrows,
            'overdueBorrows' => $overdueBorrows,
            'recentBorrows' => $recentBorrows ?: [],
            'pages' => 1,
            'current_page' => 1
        ];
        
        $this->view('admin/dashboard', $viewData);
    }

    public function books()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        $books = $this->bookModel->getAllBooks();
        
        $viewData = [
            'data' => $books ?: [],
            'pages' => 1,
            'current_page' => 1,
            'total' => is_array($books) ? count($books) : 0
        ];
        
        $this->view('admin/books', $viewData);
    }

    public function students()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        $result = $this->userModel->getAllStudents($page, 30);
        $this->view('admin/students', [
            'data' => $result['data'],
            'pages' => $result['pages'],
            'current_page' => $result['current_page']
        ]);
    }

    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle book addition
            $bookData = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'isbn' => $_POST['isbn'],
                'description' => $_POST['description'],
                'available_copies' => $_POST['copies'],
                'publication_year' => $_POST['year']
            ];

            if ($this->bookModel->addBook($bookData)) {
                $_SESSION['success'] = 'Book added successfully';
            } else {
                $_SESSION['error'] = 'Failed to add book';
            }
            header('Location: ' . URL_ROOT . '/admin/books');
            exit();
        }

        $this->view('admin/add-book');
    }

    public function updateBook($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle book update
            $bookData = [
                'id' => $id,
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'isbn' => $_POST['isbn'],
                'description' => $_POST['description'],
                'available_copies' => $_POST['copies'],
                'publication_year' => $_POST['year']
            ];

            if ($this->bookModel->updateBook($bookData)) {
                $_SESSION['success'] = 'Book updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update book';
            }
            header('Location: ' . URL_ROOT . '/admin/books');
            exit();
        }

        $book = $this->bookModel->getBookById($id);
        $this->view('admin/edit-book', ['book' => $book]);
    }

    public function borrowHistory()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        $result = $this->bookModel->getAllBorrows($page, 30);
        $this->view('admin/borrow-history', [
            'data' => $result['data'],
            'pages' => $result['pages'],
            'current_page' => $result['current_page']
        ]);
    }

    public function editBook($id = null)
    {
        // Check if ID is provided
        if ($id === null) {
            header('Location: ' . URL_ROOT . '/admin/books');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'author' => trim($_POST['author']),
                'isbn' => trim($_POST['isbn']),
                'available_copies' => (int)$_POST['available_copies']
            ];

            // Update book
            if ($this->bookModel->updateBook($data)) {
                $_SESSION['success'] = 'Book Updated Successfully';
            } else {
                $_SESSION['error'] = 'Failed to update book';
            }
            header('Location: ' . URL_ROOT . '/admin/books');
            exit();
        }

        header('Location: ' . URL_ROOT . '/admin/books');
        exit();
    }
} 