<?php
require_once '../app/models/Book.php';

class BooksController extends Controller
{
    private $bookModel;

    public function __construct($db)
    {
        $this->bookModel = new Book($db);
    }

    public function index()
    {
        return $this->browse();
    }

    public function browse()
    {
        try {
            $books = $this->bookModel->getAllBooks();
            $data = ['books' => $books];
            $this->view('books/browse', $data);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . URL_ROOT . '/dashboard');
            exit();
        }
    }

    public function borrow()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL_ROOT . '/books');
            exit();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit();
        }

        // Get form data
        $book_id = $_POST['book_id'];
        $return_date = $_POST['return_date'];

        // Check if book is available
        $book = $this->bookModel->getBookById($book_id);
        if (!$book || $book['available_copies'] <= 0) {
            $_SESSION['error'] = 'Book is not available';
            header('Location: ' . URL_ROOT . '/books');
            exit();
        }

        $transaction = [
            'student_id' => $_SESSION['user_id'],
            'book_id' => $book_id,
            'borrow_date' => date('Y-m-d'),
            'return_date' => $return_date,
            'status' => 'borrowed'
        ];

        try {
            if ($this->bookModel->borrowBook($transaction)) {
                $_SESSION['success'] = 'Book borrowed successfully!';
            } else {
                $_SESSION['error'] = 'Failed to borrow book';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error processing request';
        }

        header('Location: ' . URL_ROOT . '/books');
        exit();
    }
}
