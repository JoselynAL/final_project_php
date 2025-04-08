<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/CarController.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../middlewares/RoleMiddleware.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
header("Content-Type: application/json");

$database = new Database();
$db = $database->connect();

// POST /api/register → register new user
if ($method === 'POST' && preg_match('/\/api\/register$/', $requestUri)) {
    $input = json_decode(file_get_contents('php://input'), true);
    $controller = new UserController($db);
    echo $controller->register($input);
}

// POST /api/login → user login
else if ($method === 'POST' && preg_match('/\/api\/login$/', $requestUri)) {
    $input = json_decode(file_get_contents('php://input'), true);
    echo AuthController::login($db, $input);
}

// POST /api/logout → user logout
else if ($method === 'POST' && preg_match('/\/api\/logout$/', $requestUri)) {
    echo AuthController::logout();
}

// GET /api/check session → check session & logged in user
else if ($method === 'GET' && preg_match('/\/api\/profile$/', $requestUri)) {
    AuthMiddleware::check();
    echo AuthController::checkSession();
}

// GET /api/cars → get all cars (public)
else if ($method === 'GET' && preg_match('/\/api\/cars$/', $requestUri)) {
    $controller = new CarController($db);
    echo $controller->getAll();
}

// GET /api/cars/{id} → get one car (public)
else if ($method === 'GET' && preg_match('/\/api\/cars\/(\d+)$/', $requestUri, $matches)) {
    $carId = $matches[1];
    $controller = new CarController($db);
    echo $controller->getOne($carId);
}

// POST /api/cars → create car (admin or seller only)
else if ($method === 'POST' && preg_match('/\/api\/cars$/', $requestUri)) {
    AuthMiddleware::check();
    RoleMiddleware::allowOnly(['admin', 'seller']);
    $input = json_decode(file_get_contents('php://input'), true);
    $controller = new CarController($db);
    echo $controller->create($input);
}

// PUT /api/cars/{id} → update car (admin or seller only)
else if ($method === 'PUT' && preg_match('/\/api\/cars\/(\d+)$/', $requestUri, $matches)) {
    AuthMiddleware::check();
    RoleMiddleware::allowOnly(['admin', 'seller']);
    $carId = $matches[1];
    $input = json_decode(file_get_contents('php://input'), true);
    $controller = new CarController($db);
    echo $controller->update($carId, $input);
}

// DELETE /api/cars/{id} → delete car (admin only)
else if ($method === 'DELETE' && preg_match('/\/api\/cars\/(\d+)$/', $requestUri, $matches)) {
    AuthMiddleware::check();
    RoleMiddleware::allowOnly(['admin']);
    $carId = $matches[1];
    $controller = new CarController($db);
    echo $controller->delete($carId);
}

// unknown route
else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}