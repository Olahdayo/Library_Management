<?php
namespace App\Models;

class Transaction {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($data) {
        // Implementation for creating a transaction
    }

    public function addTransaction($data) {
        $this->db->query('INSERT INTO transactions (student_id, book_id, borrow_date, return_date, status) 
                          VALUES (:student_id, :book_id, :borrow_date, :return_date, :status)');

        // Bind values
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':book_id', $data['book_id']);
        $this->db->bind(':borrow_date', $data['borrow_date']);
        $this->db->bind(':return_date', $data['return_date']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commitTransaction() {
        $this->db->commit();
    }

    public function rollbackTransaction() {
        $this->db->rollback();
    }

    public function getTransactionsByStudent($studentId) {
        $this->db->query('SELECT t.*, b.title, b.author 
                         FROM transactions t 
                         JOIN books b ON t.book_id = b.id 
                         WHERE t.student_id = :student_id 
                         ORDER BY t.created_at DESC');
        
        $this->db->bind(':student_id', $studentId);
        
        return $this->db->resultSet();
    }
} 