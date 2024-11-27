<?php
class Transactions extends Controller {
    private $transactionModel;
    private $bookModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit;
        }
        $this->transactionModel = $this->model('Transaction');
        $this->bookModel = $this->model('Book');
    }

    public function borrow() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        // Get JSON data
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        // Check if book is available
        $book = $this->bookModel->getBookById($data['book_id']);
        if (!$book || $book['available_copies'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Book is not available']);
            return;
        }

        $transaction = [
            'student_id' => $_SESSION['user_id'],
            'book_id' => $data['book_id'],
            'borrow_date' => date('Y-m-d'),
            'return_date' => $data['return_date'],
            'status' => 'borrowed'
        ];

        // Start transaction
        $this->transactionModel->beginTransaction();

        try {
            // Add transaction record
            if ($this->transactionModel->addTransaction($transaction)) {
                // Update book available copies
                if ($this->bookModel->decrementAvailableCopies($data['book_id'])) {
                    $this->transactionModel->commitTransaction();
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            
            // If we get here, something went wrong
            $this->transactionModel->rollbackTransaction();
            echo json_encode(['success' => false, 'message' => 'Failed to borrow book']);
        } catch (Exception $e) {
            $this->transactionModel->rollbackTransaction();
            echo json_encode(['success' => false, 'message' => 'Error processing request']);
        }
    }
} 