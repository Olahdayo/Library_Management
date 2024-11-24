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
$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

// Check if controller file exists
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        // Create database connection
        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $controller = new $controllerName($db);
        
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            // Method not found
            die('Method does not exist: ' . $methodName);
        }
    } else {
        die('Controller class does not exist: ' . $controllerName);
    }
} else {
    // Controller not found
    die('Controller file does not exist: ' . $controllerFile);
} 