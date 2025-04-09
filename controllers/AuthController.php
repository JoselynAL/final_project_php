<?php
require_once __DIR__ . "/BaseController.php";

class AuthController extends BaseController
{
    // POST /api/login
    public function login($db, $input)
    {
        if (empty($input["username"]) || empty($input["password"])) {
            http_response_code(400);
            return json_encode([
                "message" => "Username and password are required",
            ]);
        }

        $username = $input["username"];
        $password = $input["password"];

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user["password"])) {
            http_response_code(401);
            // Log when login failed
            $this->logAudit(null, "login_failed", "users", null, null, [
                "username" => $username,
            ]);

            return json_encode(["message" => "Invalid username or password"]);
        }

        $_SESSION["user"] = [
            "id" => $user["id"],
            "username" => $user["username"],
            "email" => $user["email"],
            "role" => $user["role"],
        ];
        // Log when login success
        $this->logAudit($user["id"], "login", "users", $user["id"], null, null);

        http_response_code(200);
        return json_encode([
            "message" => "Login successful",
            "user" => $_SESSION["user"],
        ]);
    }

    // POST /api/logout
    public function logout()
    {
        $userId = $_SESSION["user"]["id"] ?? null;
        session_destroy();
        if ($userId !== null) {
            // Log when user logout
            $this->logAudit($userId, "logout", "users", $userId, null, null);
        }
        http_response_code(200);
        return json_encode(["message" => "Logged out successfully."]);
    }

    // GET /api/check session
    public static function checkSession() {
        if (isset($_SESSION['user'])) {
            return json_encode(['user' => $_SESSION['user']]);
        } else {
            http_response_code(401);
            return json_encode(["message" => "Not logged in"]);
        }
    }
}
