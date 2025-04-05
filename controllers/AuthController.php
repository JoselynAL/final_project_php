<?php
class AuthController {
    // POST /api/login
    public static function login($db, $input) {
        if (empty($input['username']) || empty($input['password'])) {
            http_response_code(400);
            return json_encode(['message' => 'Username and password are required']);
        }

        $username = $input['username'];
        $password = $input['password'];

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            return json_encode(['message' => 'Invalid username or password']);
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        http_response_code(200);
        return json_encode([
            'message' => 'Login successful',
            'user' => $_SESSION['user']
        ]);
    }

    // POST /api/logout
    public static function logout() {
        session_destroy();
        http_response_code(200);
        return json_encode(['message' => 'Logged out successfully.']);
    }

    // GET /api/profile
    public static function checkSession() {
        if (isset($_SESSION['user'])) {
            return json_encode(['user' => $_SESSION['user']]);
        } else {
            http_response_code(401);
            return json_encode(['message' => 'Not logged in']);
        }
    }
}