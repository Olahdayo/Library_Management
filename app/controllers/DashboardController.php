<?php
require_once '../app/models/Transaction.php';

class DashboardController extends Controller {
    private $transactionModel;

    public function __construct($db) {
        $this->transactionModel = new Transaction($db);
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        
        // Get current borrowed books (status = 'borrowed')
        $currentBorrows = $this->transactionModel->getCurrentBorrows($studentId);
        
        // Get borrow history (all transactions)
        $borrowHistory = $this->transactionModel->getTransactionsByStudent($studentId);

        $data = [
            'currentBorrows' => $currentBorrows,
            'borrowHistory' => $borrowHistory
        ];

        $this->view('dashboard/index', $data);
    }
} 