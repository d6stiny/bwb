<?php
require_once __DIR__ . '/../config/Database.php';

class AuthController
{
    private $db;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new Database();
    }

    /**
     * Handle user registration
     */
    public function register($email, $password)
    {
        // Check if user already exists
        $stmt = $this->db->query(
            "SELECT id FROM users WHERE email = ?",
            [$email]
        );

        if ($stmt->fetch()) {
            $this->sendResponse(['error' => 'User already exists'], 409);
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        try {
            $stmt = $this->db->query(
                "INSERT INTO users (email, password) VALUES (?, ?)",
                [$email, $hashedPassword]
            );

            // Set session and redirect
            $_SESSION['user_id'] = $this->db->getConnection()->lastInsertId();
            header('Location: /dashboard');
            exit;
        } catch (Exception $e) {
            $this->sendResponse(['error' => 'Registration failed'], 500);
        }
    }

    /**
     * Handle user login
     */
    public function login($email, $password)
    {
        // Fetch user by email
        $stmt = $this->db->query(
            "SELECT id, password FROM users WHERE email = ?",
            [$email]
        );

        $user = $stmt->fetch();

        // Verify password
        if (!$user || !password_verify($password, $user['password'])) {
            $this->sendResponse(['error' => 'Invalid credentials'], 401);
        }

        // Set session and redirect
        $_SESSION['user_id'] = $user['id'];
        header('Location: /dashboard');
        exit;
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    /**
     * Get current authenticated user
     */
    public function getCurrentUser()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Fetch user by ID
        $stmt = $this->db->query(
            "SELECT id, email FROM users WHERE id = ?",
            [$_SESSION['user_id']]
        );

        $user = $stmt->fetch();

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        return $user;
    }

    /**
     * Send JSON response for AJAX requests
     */
    private function sendResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}