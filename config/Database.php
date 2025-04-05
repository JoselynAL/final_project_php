<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'car_cms';
    private $username = 'root';
    private $password = 'mysql';
    private $conn;

    // establish and return a PDO database connection
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4",
                                  $this->username,
                                  $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Database Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>