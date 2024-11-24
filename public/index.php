<?php
session_start();

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Load necessary files
require_once BASE_PATH . '/app/config/config.php';
require_once BASE_PATH . '/app/controllers/Controller.php';
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/DashboardController.php';

// Get the URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

// Get controller and method
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'DashboardController';
$methodName = !empty($urlParts[1]) ? $urlParts[1] : 'index';

// Create controller instance
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        // Method not found
        die('Method does not exist');
    }
} else {
    // Controller not found
    die('Controller does not exist');
} 