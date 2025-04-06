<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/BaseController.php";

class UserController extends BaseController
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    // POST /api/register
    public function register($data)
    {
        if (
            !isset(
                $data["username"],
                $data["email"],
                $data["password"],
                $data["role"]
            )
        ) {
            http_response_code(400);
            return json_encode(["message" => "All fields are required."]);
        }

        $user = new User($this->db);
        $user->username = $data["username"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->role = $data["role"];

        // Check for duplicate username/email
        $errors = [];

        if ($user->isUsernameExists()) {
            $errors[] = "Username already exists.";
        }

        if ($user->isEmailExists()) {
            $errors[] = "Email already exists.";
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode([
                "message" => "Validation errors occurred.",
                "errors" => $errors,
            ]);
            return;
        }

        if ($user->register()) {
            http_response_code(201);
            $this->logAudit(
                $user->id,
                "create_user",
                "users",
                $user->id,
                null,
                $data
            );
            return json_encode(["message" => "User registered successfully."]);
        } else {
            http_response_code(500);
            return json_encode(["message" => "Failed to register user."]);
        }
    }
}
