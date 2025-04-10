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

        // Define the list of predefined car images
        $predefinedImages = [
            'ferrariSF90.Stradale',
            'Maserati.GT2Stradale',
            'LamborghiniHuracan.Sterrat',
            'AstonMartin.Valkyrie'
        ];

        // Process image upload
        $uploadDirectory = 'car_images/';
        $image = $data['image'];
        $imageName = basename($image['name']);
        $uploadFile = $uploadDirectory . $imageName;

        // Validate the type of the uploaded image (only images)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Add more types if necessary
        if (!in_array($image['type'], $allowedTypes)) {
            http_response_code(400);
            return json_encode(['message' => 'Invalid image type. Only JPG, PNG, and GIF are allowed.']);
        }

        // Validate the size of the uploaded image (limit to 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($image['size'] > $maxSize) {
            http_response_code(400);
            return json_encode(['message' => 'Image size exceeds the limit of 5MB.']);
        }

        // Check if the image is one of the predefined images
        if (in_array($imageName, $predefinedImages)) {
            // Ensure the upload directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded image to the directory
            if (!move_uploaded_file($image['tmp_name'], $uploadFile)) {
                http_response_code(500);
                return json_encode(['message' => 'Failed to upload image.']);
            }
        } else {
            // Handle error if the uploaded image is not a predefined one
            http_response_code(400);
            return json_encode(['message' => 'Invalid image uploaded.']);
        }

        $this->car->brand = $data['brand'];
        $this->car->model = $data['model'];
        $this->car->year = $data['year'];
        $this->car->price = $data['price'];
        $this->car->color = $data['color'];
        $this->car->description = $data['description'] ?? '';
        $this->car->image = isset($data['image']) ? basename($data['image']) : null;
        $this->car->status = $data['status'] ?? 'in_stock';
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
            $this->logAudit(
                $_SESSION["user"]["id"] ?? null,
                "update_car",
                "cars",
                $id,
                $existingCar,
                $data
            );
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
            $this->logAudit(
                $_SESSION["user"]["id"] ?? null,
                "delete_car",
                "cars",
                $id,
                $existingCar,
                null
            );
            return json_encode(["message" => "Car deleted successfully."]);
        } else {
            http_response_code(500);
            return json_encode(["message" => "Failed to delete car."]);
        }
    }
}
