<?php
class RoleMiddleware {
    public static function allowOnly($roles = []) {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized. Please log in.']);
            exit;
        }

        $userRole = $_SESSION['user']['role'] ?? null;

        if (!in_array($userRole, $roles)) {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden. Insufficient permissions.']);
            exit;
        }
    }
}
?>