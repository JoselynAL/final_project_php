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
            $this->logAudit(
                $_SESSION["user"]["id"] ?? null,
                "view_car_detail",
                "cars",
                $id,
                null,
                null
            );
            return json_encode($car);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Car not found"]);
        }
    }

    // POST /api/cars
    public function create()
    {
        // get form data of car from post
        $data = $_POST;

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

        // Process image upload
        $uploadDirectory = __DIR__ . "/../car_images/";
        $image = $_FILES["image"] ?? null;
        if ($image && $image["error"] === UPLOAD_ERR_OK) {
            // lowercase & safe image name: brand_model_color.extension
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $brand = strtolower(
                str_replace(" ", "", $data["brand"] ?? "unknown")
            );
            $model = strtolower(
                str_replace(" ", "", $data["model"] ?? "unknown")
            );
            $color = strtolower(
                str_replace(" ", "", $data["color"] ?? "unknown")
            );
            $imageName = "{$brand}_{$model}_{$color}." . $extension;
            $uploadFile = $uploadDirectory . $imageName;

            // Validate the type of the uploaded image (only images)
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"]; // Add more types if necessary

            if (!in_array($image["type"], $allowedTypes)) {
                http_response_code(400);
                return json_encode([
                    "message" =>
                        "Invalid image type. Only JPG, PNG, and GIF are allowed.",
                ]);
            }

            // Validate the size of the uploaded image (limit to 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($image["size"] > $maxSize) {
                http_response_code(400);
                return json_encode([
                    "message" => "Image size exceeds the limit of 5MB.",
                ]);
            }

            // Ensure the upload directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded image to the directory
            if (!move_uploaded_file($image["tmp_name"], $uploadFile)) {
                http_response_code(500);
                return json_encode(["message" => "Failed to upload image."]);
            }
            $data["image"] = $imageName;
        } else {
            http_response_code(400);
            return json_encode(["message" => "Image is required."]);
        }

        $this->car->brand = $data["brand"];
        $this->car->model = $data["model"];
        $this->car->year = $data["year"];
        $this->car->price = $data["price"];
        $this->car->color = strtolower($data["color"]);
        $this->car->description = $data["description"] ?? "";
        $this->car->image = $data["image"];
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

    // POST /api/cars/{id}
    public function update($id)
    {
        $data = $_POST;

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
        if (
            isset($data["year"]) &&
            !filter_var($data["year"], FILTER_VALIDATE_INT)
        ) {
            http_response_code(400);
            return json_encode(["message" => "Year must be an integer."]);
        }

        if (
            isset($data["price"]) &&
            !filter_var($data["price"], FILTER_VALIDATE_FLOAT)
        ) {
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

        // image upload
        $uploadDirectory = __DIR__ . "/../car_images/";
        $image = $_FILES["image"] ?? null;
        if ($image && $image["error"] === UPLOAD_ERR_OK) {
            // lowercase & safe image name: brand_model_color.extension
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);

            $brandRaw = isset($data["brand"])
                ? $data["brand"]
                : $existingCar["brand"];
            $modelRaw = isset($data["model"])
                ? $data["model"]
                : $existingCar["model"];
            $colorRaw = isset($data["color"])
                ? $data["color"]
                : $existingCar["color"];

            $brand = strtolower(str_replace(" ", "", $brandRaw));
            $model = strtolower(str_replace(" ", "", $modelRaw));
            $color = strtolower(str_replace(" ", "", $colorRaw));

            $imageName = "{$brand}_{$model}_{$color}." . $extension;
            $uploadFile = $uploadDirectory . $imageName;

            // Validate the type of the uploaded image (only images)
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"]; // Add more types if necessary

            if (!in_array($image["type"], $allowedTypes)) {
                http_response_code(400);
                return json_encode([
                    "message" =>
                        "Invalid image type. Only JPG, PNG, and GIF are allowed.",
                ]);
            }

            // Validate the size of the uploaded image (limit to 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($image["size"] > $maxSize) {
                http_response_code(400);
                return json_encode([
                    "message" => "Image size exceeds the limit of 5MB.",
                ]);
            }

            // Ensure the upload directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded image to the directory
            if (!move_uploaded_file($image["tmp_name"], $uploadFile)) {
                http_response_code(500);
                return json_encode(["message" => "Failed to upload image."]);
            }

            $data["image"] = $imageName;
        }

        // assign updated values safely
        $this->car->brand = isset($data["brand"])
            ? $data["brand"]
            : $existingCar["brand"];
        $this->car->model = isset($data["model"])
            ? $data["model"]
            : $existingCar["model"];
        $this->car->year = isset($data["year"])
            ? $data["year"]
            : $existingCar["year"];
        $this->car->price = isset($data["price"])
            ? $data["price"]
            : $existingCar["price"];
        $this->car->color = isset($data["color"])
            ? strtolower($data["color"])
            : $existingCar["color"];
        $this->car->description = isset($data["description"])
            ? $data["description"]
            : $existingCar["description"];
        $this->car->image = isset($data["image"])
            ? $data["image"]
            : $existingCar["image"];
        $this->car->status = isset($data["status"])
            ? $data["status"]
            : $existingCar["status"];
        $this->car->user_id = isset($data["user_id"])
            ? $data["user_id"]
            : $existingCar["user_id"];

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
