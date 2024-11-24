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
} 