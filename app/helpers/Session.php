<?php
class Session {
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . URL_ROOT . '/auth/login');
            exit();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }
} 