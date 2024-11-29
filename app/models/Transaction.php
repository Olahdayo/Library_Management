<?php

class Transaction
{
    private $conn;
    private $table = 'transactions';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($data)
    {
        // Implementation for creating a transaction
    }

    public function addTransaction($data)
    {
        $this->conn->query('INSERT INTO transactions (student_id, book_id, borrow_date, return_date, status) 
                          VALUES (:student_id, :book_id, :borrow_date, :return_date, :status)');

        // Bind values
        $this->conn->bind(':student_id', $data['student_id']);
        $this->conn->bind(':book_id', $data['book_id']);
        $this->conn->bind(':borrow_date', $data['borrow_date']);
        $this->conn->bind(':return_date', $data['return_date']);
        $this->conn->bind(':status', $data['status']);

        return $this->conn->execute();
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->conn->commit();
    }

    public function rollbackTransaction()
    {
        $this->conn->rollback();
    }

    public function getTransactionsByStudent($studentId)
    {
        $sql = "SELECT t.*, b.title, b.author 
                FROM " . $this->table . " t 
                JOIN books b ON t.book_id = b.id 
                WHERE t.student_id = :student_id 
                ORDER BY t.borrow_date DESC";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransactionById($id) {
        $sql = "SELECT * FROM transactions WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE transactions SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function getCurrentBorrows($studentId) {
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
}
