<?php
require_once '../app/models/Book.php';

class BooksController extends Controller {
    private $bookModel;

    public function __construct($db) {
        $this->bookModel = new Book($db);
    }

    public function index() {
        return $this->browse();
    }

    public function browse() {
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
}
