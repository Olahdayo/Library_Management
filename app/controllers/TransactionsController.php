<?php
require_once '../app/models/Transaction.php';
require_once '../app/models/Book.php';

class TransactionsController extends Controller
{
    private $transactionModel;
    private $bookModel;

    public function __construct($db)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit;
        }
        $this->transactionModel = new Transaction($db);
        $this->bookModel = new Book($db);
    }

    public function index()
    {
        $studentId = $_SESSION['user_id'];
        $transactions = $this->transactionModel->getTransactionsByStudent($studentId);
        $this->view('transactions/index', ['transactions' => $transactions]);
    }

    public function myBooks()
    {
        $studentId = $_SESSION['user_id'];
        $transactions = $this->transactionModel->getTransactionsByStudent($studentId);
        $this->view('transactions/my-books', ['transactions' => $transactions]);
    }

    public function returnBook()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL_ROOT . '/transactions/myBooks');
            exit();
        }

        $transactionId = $_POST['transaction_id'];
        // Process return logic here
        header('Location: ' . URL_ROOT . '/transactions/myBooks');
        exit();
    }
}
