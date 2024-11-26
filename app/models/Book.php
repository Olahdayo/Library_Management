<?php
class Book {
    private $conn;
    private $table = 'books';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBooks() {
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
}
