<?php
require_once '../app/models/Transaction.php';

class DashboardController extends Controller
{
    private $transactionModel;

    public function __construct($db)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit;
        }
        $this->transactionModel = new Transaction($db);
    }

    public function index()
    {
        $studentId = $_SESSION['user_id'];
        $currentBorrows = $this->transactionModel->getCurrentBorrows($studentId);
        
        $_SESSION['total_books_borrowed'] = count($currentBorrows);

        $this->view('dashboard/index', [
            'currentBorrows' => $currentBorrows,
            'borrowHistory' => $this->transactionModel->getTransactionsByStudent($studentId)
        ]);
    }
}
