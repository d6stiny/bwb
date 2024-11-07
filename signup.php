<?php
require_once 'controllers/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $auth = new AuthController();
    
    try {
        $auth->register($email, $password);
        // Registration successful - user will be automatically redirected by AuthController
    } catch (Exception $e) {
        // Handle error
        header('Location: /signup.html?error=' . urlencode($e->getMessage()));
        exit;
    }
}