<?php

class Session
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function checkPreviousUrl()
    {
        if (isset($_SESSION['prev_url'])) {
            $current_url = $_SERVER['REQUEST_URI'];
            if ($_SESSION['prev_url'] !== $current_url) {
                header('Location: ' . URL_ROOT . '/auth/login');
                exit();
            }
        }
    }
} 