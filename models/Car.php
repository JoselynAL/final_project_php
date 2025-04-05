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

    }

    // get all car list
    public function getAll() {

    }

    // get one car by ID
    public function getById($id) {

    }

    // update a car
    public function update($id) {

    }

    // delete a car
    public function delete($id) {

    }
}
?>