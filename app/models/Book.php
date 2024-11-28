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
            $sql = "SELECT *, 
                    CASE WHEN available_copies > 0 THEN 'Available' ELSE 'Not Available' END as available 
                    FROM " . $this->table . " ORDER BY title ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to fetch books");
        }
    }

    public function decrementAvailableCopies($bookId)
    {
        $sql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = :id AND available_copies > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $bookId);
        return $stmt->execute();
    }

    public function borrowBook($transaction) {
        // Update book copies
        $sql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = :book_id AND available_copies > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':book_id', $transaction['book_id']);
        
        // Add transaction record
        $sql2 = "INSERT INTO transactions (student_id, book_id, borrow_date, return_date, status) VALUES (:student_id, :book_id, :borrow_date, :return_date, :status)";
        $stmt2 = $this->conn->prepare($sql2);
        
        return $stmt->execute() && $stmt2->execute($transaction);
    }

    public function getBookById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementAvailableCopies($bookId) {
        $sql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $bookId);
        return $stmt->execute();
    }
}
