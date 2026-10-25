<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES,
            'UTF-8'
        );
    }
}

if (!function_exists('redirect')) {
    function redirect($path) {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('flash')) {
    function flash($message, $type = 'success') {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];
    }
}

if (!function_exists('show_flash')) {
    function show_flash() {
        if (isset($_SESSION['flash'])) {
            $data = $_SESSION['flash'];

            $type = $data['type'] ?? 'success';
            $message = $data['message'] ?? '';

            echo '<div class="alert ' . e($type) . '">';
            echo e($message);
            echo '</div>';

            unset($_SESSION['flash']);
        }
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('require_login')) {
    function require_login() {
        if (!is_logged_in()) {
            flash('Please log in to continue.', 'error');
            redirect('login.php');
        }
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verify_csrf')) {
    function verify_csrf($token) {
        return isset($_SESSION['csrf_token'])
            && is_string($token)
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}