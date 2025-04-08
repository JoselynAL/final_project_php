<?php
class Car {
    private $conn;
    private $table = 'cars';

    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $color;
    public $description;
    public $image;
    public $status;
    public $user_id;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // create a new car
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (brand, model, year, price, color, description, image, status, user_id)
                  VALUES (:brand, :model, :year, :price, :color, :description, :image, :status, :user_id)";
        $stmt = $this->conn->prepare($query);

        // sanitize and prepare data
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = intval($this->year);
        $this->price = floatval($this->price);
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->user_id = $this->user_id ? intval($this->user_id) : null;

        // bind parameters
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':user_id', $this->user_id);

        return $stmt->execute();
    }

    // get all car list
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // get one car by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update a car
    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                  SET brand = :brand, model = :model, year = :year, price = :price, 
                      color = :color, description = :description, image = :image, 
                      status = :status, user_id = :user_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // sanitize and prepare data
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = intval($this->year);
        $this->price = floatval($this->price);
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->user_id = $this->user_id ? intval($this->user_id) : null;

        // bind parameters
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // delete a car
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
?>