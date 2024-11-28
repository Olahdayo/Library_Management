<?php
class View {
    public static function render($view, $data = []) {
        // Extract data to make it available in view
        extract($data);
        
        // Define the view path
        $viewPath = APP_PATH . '/views/' . $view . '.php';
        
        // Start output as string
        ob_start();
        
        // Include header
        require_once APP_PATH . '/views/layouts/header.php';
        
        // Include the main view file
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View file not found: ' . $viewPath);
        }
        
        // Include footer
        require_once APP_PATH . '/views/layouts/footer.php';
        
        // Return the string content and clear buffer
        return ob_get_clean();
    }
} 