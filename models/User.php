<?php
class User
{
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // register a new user
    public function register()
    {
        try {
            $query =
                "INSERT INTO " .
                $this->table .
                " (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->conn->prepare($query);

            // sanitize and prepare data
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->role = htmlspecialchars(strip_tags($this->role));

            // bind parameters
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":role", $this->role);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log("User Register Error: " . $e->getMessage());
            return false;
        }
    }

    // check if username already exists
    public function isUsernameExists()
    {
        try {
            $query = "SELECT id FROM {$this->table} WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Check Username Exists Error: " . $e->getMessage());
            return false;
        }
    }

    // check if email already exists
    public function isEmailExists()
    {
        try {
            $query = "SELECT id FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Check Email Exists Error: " . $e->getMessage());
            return false;
        }
    }
}
?>