<?php
require_once 'controllers/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $auth = new AuthController();
    
    try {
        $auth->login($email, $password);
    } catch (Exception $e) {
        // Handle error
        header('Location: /login.html?error=' . urlencode($e->getMessage()));
        exit;
    }
}