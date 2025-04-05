<?php
class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized. Please log in.']);
            exit;
        }
    }
}
?>