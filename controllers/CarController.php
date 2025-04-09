<?php
require_once __DIR__ . "/../models/Car.php";
require_once __DIR__ . "/BaseController.php";

class CarController extends BaseController
{
    private $car;

    public function __construct($db)
    {
        $this->db = $db;
        $this->car = new Car($db);
    }

    // GET /api/cars
    public function getAll()
    {
        $stmt = $this->car->getAll();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($cars);
    }

    // GET /api/cars/{id}
    public function getOne($id)
    {
        $car = $this->car->getById($id);

        if ($car) {
            return json_encode($car);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Car not found"]);
        }
    }

    // POST /api/cars
    public function create($data)
    {
        // required fields check
        $required = ["brand", "model", "year", "price", "color"];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                return json_encode([
                    "message" => "Field '$field' is required.",
                ]);
            }
        }

        // validate numeric fields
        if (!filter_var($data["year"], FILTER_VALIDATE_INT)) {
            http_response_code(400);
            return json_encode(["message" => "Year must be an integer."]);
        }

        if (!filter_var($data["price"], FILTER_VALIDATE_FLOAT)) {
            http_response_code(400);
            return json_encode(["message" => "Price must be a valid number."]);
        }

        if (
            isset($data["user_id"]) &&
            !filter_var($data["user_id"], FILTER_VALIDATE_INT)
        ) {
            http_response_code(400);
            return json_encode(["message" => "User ID must be an integer."]);
        }

        // validate status
        $validStatuses = ["in_stock", "reserved", "sold"];
        if (
            isset($data["status"]) &&
            !in_array($data["status"], $validStatuses)
        ) {
            http_response_code(400);
            return json_encode([
                "message" =>
                    "Invalid status. Must be one of: in_stock, reserved, sold.",
            ]);
        }

        $this->car->brand = $data["brand"];
        $this->car->model = $data["model"];
        $this->car->year = $data["year"];
        $this->car->price = $data["price"];
        $this->car->color = $data["color"];
        $this->car->description = $data["description"] ?? "";
        $this->car->image = isset($data["image"])
            ? basename($data["image"])
            : null;
        $this->car->status = $data["status"] ?? "in_stock";
        $this->car->user_id = $_SESSION["user"]["id"];

        if ($this->car->create()) {
            http_response_code(201);
            $this->logAudit(
                $this->car->user_id ?? null,
                "create_car",
                "cars",
                $this->car->id,
                null,
                $data
            );
            return json_encode(["message" => "Car created successfully."]);
        } else {
            http_response_code(500);
            return json_encode(["message" => "Failed to create car."]);
        }
    }

    // PUT /api/cars/{id}
    public function update($id, $data)
    {
        $existingCar = $this->car->getById($id);

        if (!$existingCar) {
            http_response_code(404);
            return json_encode(["message" => "Car not found."]);
        }

        // validate status
        $validStatuses = ["in_stock", "reserved", "sold"];
        if (
            isset($data["status"]) &&
            !in_array($data["status"], $validStatuses)
        ) {
            http_response_code(400);
            return json_encode([
                "message" =>
                    "Invalid status. Must be one of: in_stock, reserved, sold.",
            ]);
        }

        // validate numeric fields
        if (!filter_var($data["year"], FILTER_VALIDATE_INT)) {
            http_response_code(400);
            return json_encode(["message" => "Year must be an integer."]);
        }

        if (!filter_var($data["price"], FILTER_VALIDATE_FLOAT)) {
            http_response_code(400);
            return json_encode(["message" => "Price must be a valid number."]);
        }

        if (
            isset($data["user_id"]) &&
            !filter_var($data["user_id"], FILTER_VALIDATE_INT)
        ) {
            http_response_code(400);
            return json_encode(["message" => "User ID must be an integer."]);
        }

        $this->car->brand = $data["brand"] ?? $existingCar["brand"];
        $this->car->model = $data["model"] ?? $existingCar["model"];
        $this->car->year = $data["year"] ?? $existingCar["year"];
        $this->car->price = $data["price"] ?? $existingCar["price"];
        $this->car->color = $data["color"] ?? $existingCar["color"];
        $this->car->description =
            $data["description"] ?? $existingCar["description"];
        $this->car->image = isset($data["image"])
            ? basename($data["image"])
            : $existingCar["image"];
        $this->car->status = $data["status"] ?? $existingCar["status"];
        $this->car->user_id = $data["user_id"] ?? $existingCar["user_id"];

        if ($this->car->update($id)) {
            return json_encode(["message" => "Car updated successfully."]);
        } else {
            http_response_code(500);
            return json_encode(["message" => "Failed to update car."]);
        }
    }

    // DELETE /api/cars/{id}
    public function delete($id)
    {
        $existingCar = $this->car->getById($id);

        if (!$existingCar) {
            http_response_code(404);
            return json_encode(["message" => "Car not found."]);
        }

        if ($this->car->delete($id)) {
            return json_encode(["message" => "Car deleted successfully."]);
        } else {
            http_response_code(500);
            return json_encode(["message" => "Failed to delete car."]);
        }
    }
}
