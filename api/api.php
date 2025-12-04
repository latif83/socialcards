<?php
// Start session for login/registration
session_start();
header('Content-Type: application/json'); // API responses are usually JSON

// Includes
require_once __DIR__ . '/../config.php';     // Your SQLite PDO connection
require_once __DIR__ . '/controllers/AuthController.php'; // New Controller file

// --- 1. Get Route and Method ---
$route = $_GET['route'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$response = ['success' => false, 'message' => 'Invalid Request'];

// --- 2. Dispatcher Logic ---

// A simple map to direct routes to controllers/methods
$routes = [
    // Route Name       => [Controller Class, Method Name]
    'login'           => ['AuthController', 'handleLogin'],
    'register'        => ['AuthController', 'handleRegister'],
    // 'addCard'         => ['CardController', 'handleAdd'], // Future routes
    // 'deleteCard'      => ['CardController', 'handleDelete'], // Future routes
];

if (isset($routes[$route])) {
    list($controllerName, $methodName) = $routes[$route];
    
    // Check if the Controller class exists
    if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
        // Instantiate the controller, passing the database connection
        $controller = new $controllerName($db);
        
        // Execute the method and capture the response
        $response = $controller->$methodName($_POST, $method);
        
    } else {
        $response['message'] = "API Controller or method not found.";
    }
} else {
    $response['message'] = "Route '{$route}' not defined.";
}

// Output the final JSON response
echo json_encode($response);
exit;