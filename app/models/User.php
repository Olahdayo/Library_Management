<?php
class User
{
    private $conn;
    private $table = 'students';

    public $id;
    public $name;
    public $username;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $query = "SELECT id, name, UserName, email, phone, sex, age, password, total_books_borrowed 
                  FROM " . $this->table . " 
                  WHERE UserName = :username";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // Remove password from array
                return $user;
            }

            return false;
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            return false;
        }
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                unset($user['password']); // Remove password from the result
            }
            return $user;
        } catch (PDOException $e) {
            error_log('Error finding user by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function update($data)
    {
        $query = "UPDATE " . $this->table . " 
                 SET name = :name, 
                     email = :email, 
                     phone = :phone 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    public function updatePassword($id, $newPassword)
    {
        $query = "UPDATE " . $this->table . " 
                 SET password = :password 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function findUserByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE UserName = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findUserByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (name, UserName, email, phone, sex, age, password) 
                  VALUES 
                  (:name, :username, :email, :phone, :sex, :age, :password)";

        try {
            $stmt = $this->conn->prepare($query);

            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Bind values
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':sex', $data['gender']);
            $stmt->bindParam(':age', $data['age']);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }

            return false;
        } catch (PDOException $e) {
            error_log('Registration error: ' . $e->getMessage());
            return false;
        }
    }

    public function getStudentStats($studentId)
    {
        $stats = [
            'total_borrowed' => 0,
            'books_due_soon' => 0,
            'overdue_books' => 0
        ];

        try {
            // Get total borrowed books
            $query = "SELECT COUNT(*) as total FROM borrowed_books WHERE student_id = :student_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->execute();
            $stats['total_borrowed'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Get books due in the next 7 days
            $query = "SELECT COUNT(*) as due_soon FROM borrowed_books 
                     WHERE student_id = :student_id 
                     AND due_date BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
                     AND returned_date IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->execute();
            $stats['books_due_soon'] = $stmt->fetch(PDO::FETCH_ASSOC)['due_soon'];

            // Get overdue books
            $query = "SELECT COUNT(*) as overdue FROM borrowed_books 
                     WHERE student_id = :student_id 
                     AND due_date < CURRENT_DATE
                     AND returned_date IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->execute();
            $stats['overdue_books'] = $stmt->fetch(PDO::FETCH_ASSOC)['overdue'];

            return $stats;
        } catch (PDOException $e) {
            error_log('Error getting student stats: ' . $e->getMessage());
            return $stats;
        }
    }

    public function verifyPassword($userId, $currentPassword)
    {
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($currentPassword, $user['password']);
    }

    public function updateUser($id, $data)
    {
        try {
            // Start with basic fields
            $sql = "UPDATE " . $this->table . " SET name = :name, email = :email, phone = :phone, age = :age";
            $params = [
                ':id' => $id,
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':phone' => $data['phone'],
                ':age' => $data['age']
            ];

            // Handle password update
            if (!empty($data['current_password']) && !empty($data['new_password'])) {
                // Verify current password...
                if ($this->verifyPassword($id, $data['current_password'])) {
                    $sql .= ", password = :password";
                    $params[':password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                } else {
                    throw new Exception("Current password is incorrect");
                }
            }

            $sql .= " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to update profile: " . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to fetch user data");
        }
    }
}
