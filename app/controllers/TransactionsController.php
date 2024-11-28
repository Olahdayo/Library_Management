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

    public function returnBook() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL_ROOT . '/dashboard');
            exit();
        }

        $response = ['success' => false, 'message' => ''];
        $transactionId = $_POST['transaction_id'];
        
        try {
            // Get transaction details
            $transaction = $this->transactionModel->getTransactionById($transactionId);
            
            if ($transaction && $transaction['student_id'] == $_SESSION['user_id']) {
                // Update transaction status
                if ($this->transactionModel->updateStatus($transactionId, 'returned')) {
                    // Increment available copies
                    $this->bookModel->incrementAvailableCopies($transaction['book_id']);
                    $_SESSION['success'] = 'Book returned successfully!';
                } else {
                    $_SESSION['error'] = 'Failed to return book';
                }
            } else {
                $_SESSION['error'] = 'Invalid transaction';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error processing return';
        }

        header('Location: ' . URL_ROOT . '/dashboard');
        exit();
    }

    public function history() {
        $studentId = $_SESSION['user_id'];
        $borrowHistory = $this->transactionModel->getTransactionsByStudent($studentId);
        $this->view('transactions/history', ['borrowHistory' => $borrowHistory]);
    }
}
