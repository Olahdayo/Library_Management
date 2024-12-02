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
        $sql = "SELECT * FROM books ORDER BY title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
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

    public function searchBooks($searchTerm)
    {
        try {
            $searchTerm = '%' . trim($searchTerm) . '%';
            
            $sql = "SELECT *, 
                    CASE WHEN available_copies > 0 THEN 'Available' ELSE 'Not Available' END as available 
                    FROM " . $this->table . " 
                    WHERE (LOWER(title) LIKE LOWER(:search) 
                    OR LOWER(author) LIKE LOWER(:search))
                    ORDER BY title ASC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':search', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to search books");
        }
    }

    public function getTotalBooks()
    {
        $sql = "SELECT COUNT(*) as total FROM books";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getRecentBorrows()
    {
        $sql = "SELECT t.*, s.name as student_name, b.title as book_title 
                FROM transactions t 
                JOIN students s ON t.student_id = s.id 
                JOIN books b ON t.book_id = b.id 
                ORDER BY t.created_at DESC LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockBooks()
    {
        $sql = "SELECT * FROM books WHERE available_copies <= 2 ORDER BY available_copies ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook($data)
    {
        $sql = "INSERT INTO books (title, author, isbn, description, available_copies, publication_year) 
                VALUES (:title, :author, :isbn, :description, :available_copies, :publication_year)";
                
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':isbn' => $data['isbn'],
            ':description' => $data['description'],
            ':available_copies' => $data['available_copies'],
            ':publication_year' => $data['publication_year']
        ]);
    }

    public function updateBook($data)
    {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    isbn = :isbn, 
                    description = :description,
                    available_copies = :available_copies 
                WHERE id = :id";
                
        try {
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindValue(':title', $data['title']);
            $stmt->bindValue(':author', $data['author']);
            $stmt->bindValue(':isbn', $data['isbn']);
            $stmt->bindValue(':description', $data['description']);
            $stmt->bindValue(':available_copies', $data['available_copies'], PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllBorrows($page = 1, $perPage = 30)
    {
        $offset = ($page - 1) * $perPage;
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) as total FROM transactions";
        $countStmt = $this->conn->prepare($countSql);
        $countStmt->execute();
        $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Get paginated results
        $sql = "SELECT 
                    t.*,
                    s.name as student_name,
                    s.UserName as student_username,
                    b.title as book_title,
                    CASE 
                        WHEN t.status = 'borrowed' AND t.borrow_date < CURRENT_DATE - INTERVAL 7 DAY THEN 'OVERDUE'
                        ELSE UPPER(t.status)
                    END as borrow_status
                FROM transactions t 
                JOIN students s ON t.student_id = s.id 
                JOIN books b ON t.book_id = b.id 
                ORDER BY t.created_at DESC
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Ensure it returns an array even if no results
        return [
            'data' => $data ? $data : [],
            'total' => $totalRows,
            'pages' => ceil($totalRows / $perPage),
            'current_page' => $page
        ];
    }

    public function getActiveBorrows($page = 1, $perPage = 30)
    {
        $offset = ($page - 1) * $perPage;
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) as total 
                     FROM transactions t 
                     WHERE t.status = 'borrowed'";
        $countStmt = $this->conn->prepare($countSql);
        $countStmt->execute();
        $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Get paginated results
        $sql = "SELECT 
                    t.*,
                    s.name as student_name,
                    s.UserName as student_username,
                    b.title as book_title,
                    CASE 
                        WHEN t.status = 'borrowed' AND t.borrow_date < CURRENT_DATE - INTERVAL 7 DAY THEN 'OVERDUE'
                        ELSE 'BORROWED'
                    END as borrow_status
                FROM transactions t 
                JOIN students s ON t.student_id = s.id 
                JOIN books b ON t.book_id = b.id 
                WHERE t.status = 'borrowed'
                ORDER BY t.created_at DESC";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOverdueBorrowsCount()
    {
        $sql = "SELECT COUNT(*) as count 
                FROM transactions 
                WHERE status = 'borrowed' 
                AND borrow_date < CURRENT_DATE - INTERVAL 7 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getActiveBorrowsCount()
    {
        $sql = "SELECT COUNT(*) as count 
                FROM transactions 
                WHERE status = 'borrowed' 
                AND borrow_date >= CURRENT_DATE - INTERVAL 7 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function hasActiveBorrows($id)
    {
        $sql = "SELECT COUNT(*) as count FROM transactions 
                WHERE book_id = :id AND status = 'BORROWED'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
