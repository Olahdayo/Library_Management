<?php

class Transaction
{
    private $conn;
    private $table = 'transactions';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addTransaction($data)
    {
        try {
            $sql = 'INSERT INTO transactions (student_id, book_id, borrow_date, return_date, status) 
                    VALUES (:student_id, :book_id, :borrow_date, :return_date, :status)';
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':book_id', $data['book_id']);
            $stmt->bindParam(':borrow_date', $data['borrow_date']);
            $stmt->bindParam(':return_date', $data['return_date']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error in addTransaction: " . $e->getMessage());
            return false;
        }
    }

    public function getTransactionById($id)
    {
        $sql = "SELECT * FROM transactions WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE transactions SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function getCurrentBorrows($studentId)
    {
        $sql = "SELECT t.*, b.title, b.author 
                FROM transactions t 
                JOIN books b ON t.book_id = b.id 
                WHERE t.student_id = :student_id 
                AND t.status = 'borrowed' 
                ORDER BY t.borrow_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransactionsByStudent($studentId)
    {
        $sql = "SELECT t.*, b.title, b.author 
                FROM transactions t 
                JOIN books b ON t.book_id = b.id 
                WHERE t.student_id = :student_id 
                ORDER BY t.borrow_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
