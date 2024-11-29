<?php
class Book
{
    private $conn;
    private $table = 'books';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllBooks()
    {
        try {
            $sql = "SELECT b.*, 
                    CASE WHEN b.available_copies > 0 THEN 'Available' ELSE 'Not Available' END as available,
                    b.description,
                    b.publication_year
                    FROM " . $this->table . " b 
                    ORDER BY b.title ASC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to fetch books");
        }
    }

    public function borrowBook($transaction)
    {
        try {
            $this->conn->beginTransaction();
            
            // Update available copies
            $sql = "UPDATE books SET available_copies = available_copies - 1 
                    WHERE id = :book_id AND available_copies > 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':book_id', $transaction['book_id']);
            $updateResult = $stmt->execute();

            if (!$updateResult) {
                $this->conn->rollback();
                return false;
            }

            // Create transaction record
            $transactionModel = new Transaction($this->conn);
            $transactionResult = $transactionModel->addTransaction($transaction);

            if (!$transactionResult) {
                $this->conn->rollback();
                return false;
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            error_log("Error in borrowBook: " . $e->getMessage());
            $this->conn->rollback();
            return false;
        }
    }

    public function getBookById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkExistingBorrow($studentId, $bookId)
    {
        try {
            $sql = "SELECT COUNT(*) as active_borrow 
                    FROM transactions 
                    WHERE student_id = :student_id 
                    AND book_id = :book_id 
                    AND status = 'borrowed'";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->bindParam(':book_id', $bookId);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['active_borrow'] > 0;
        } catch (Exception $e) {
            error_log("Error checking existing borrow: " . $e->getMessage());
            return false;
        }
    }

    public function incrementAvailableCopies($bookId) {
        $sql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $bookId);
        return $stmt->execute();
    }
}
