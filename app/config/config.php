<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_management_system');

// Path Configuration
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(__FILE__)));
}
define('APP_PATH', dirname(__DIR__));
define('URL_ROOT', 'http://localhost/library_management/public');
define('SITE_NAME', 'Library Management System');

// Debug paths
echo "<!-- Debug: BASE_PATH = " . BASE_PATH . " -->";
echo "<!-- Debug: APP_PATH = " . APP_PATH . " -->";

// Define base path for the application
define('APPROOT', dirname(dirname(__FILE__)));
 