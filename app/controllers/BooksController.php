<?php
require_once '../app/models/Book.php';

class BooksController extends Controller
{
    private $bookModel;

    public function __construct($db)
    {
        $this->bookModel = new Book($db);
    }

    public function index($action = '')
    {
        switch ($action) {
            case 'borrow':
                $this->borrow();
                break;
            default:
                $this->browse();
                break;
        }
    }

    public function browse()
    {
        try {
            $books = $this->bookModel->getAllBooks();
            $this->view('books/browse', ['books' => $books]);
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

        $book_id = $_POST['book_id'];
        $return_date = $_POST['return_date'];

        if ($this->bookModel->checkExistingBorrow($_SESSION['user_id'], $book_id)) {
            $_SESSION['error'] = 'You already have borrowed this book';
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
                $_SESSION['total_books_borrowed'] = ($_SESSION['total_books_borrowed'] ?? 0) + 1;
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
