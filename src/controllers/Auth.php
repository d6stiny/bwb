<?php

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function sendResponse($data, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function register($name, $email, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendResponse(['error' => 'Invalid email'], 400);
        }

        $stmt = $this->db->query(
            "SELECT id FROM user WHERE email = ?",
            [$email]
        );

        if ($stmt->fetch()) {
            $this->sendResponse(['error' => 'Email already exists'], 400);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->query(
                "INSERT INTO user (name, email, password) VALUES (?, ?, ?)",
                [$name, $email, $hashedPassword]
            );
            
            $_SESSION['user_id'] = $this->db->getConnection()->lastInsertId();
            $this->sendResponse([
                'message' => 'Registration successful',
                'user_id' => $_SESSION['user_id']
            ], 201);
        } catch (Exception $e) {
            $this->sendResponse(['error' => 'Registration failed'], 500);
        }
    }

    public function login($email, $password) {
        $stmt = $this->db->query(
            "SELECT id, password FROM user WHERE email = ?",
            [$email]
        );
        
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->sendResponse(['error' => 'Invalid credentials'], 401);
        }

        $_SESSION['user_id'] = $user['id'];
        $this->sendResponse(['message' => 'Login successful', 'user_id' => $user['id']]);
    }

    public function logout() {
        session_destroy();
        $this->sendResponse(['message' => 'Logout successful']);
    }

    public function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            $this->sendResponse(['error' => 'Not authenticated'], 401);
        }

        $stmt = $this->db->query(
            "SELECT id, name, email FROM user WHERE id = ?",
            [$_SESSION['user_id']]
        );
        
        $user = $stmt->fetch();
        
        if (!$user) {
            session_destroy();
            $this->sendResponse(['error' => 'User not found'], 404);
        }

        $this->sendResponse($user);
    }
}