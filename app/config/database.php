<?php
class Database
{
    private $host = "localhost";
    private $db_name = "library_management_system";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<!-- Debug: Database connection successful -->";
        } catch (PDOException $e) {
            echo "<!-- Debug: Database connection failed: " . $e->getMessage() . " -->";
        }

        return $this->conn;
    }
}
