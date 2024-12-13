<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if needed
session_start();

// Set default content type
header('Content-Type: text/html; charset=utf-8');

function sanitizePath($path)
{
    return preg_replace('#/+#', '/', '/' . trim($path, '/'));
}

try {
    // Get and sanitize the request path
    $requestUri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    $path = sanitizePath(parse_url($requestUri, PHP_URL_PATH));
    $documentRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

    // Debug logging
    error_log("[Router] Original URI: {$requestUri}");
    error_log("[Router] Sanitized Path: {$path}");
    error_log("[Router] Document Root: {$documentRoot}");

    // Validate environment
    if (!$documentRoot || !is_dir($documentRoot)) {
        throw new RuntimeException('Invalid document root configuration');
    }

    // Security check
    if (strpos($path, '..') !== false) {
        throw new RuntimeException('Directory traversal attempt detected');
    }

    // Route mapping
    $routes = [
        '/404' => '404.php',
        '/dashboard' => 'dashboard.php',
        '/login' => 'login.php',
        '/logout' => 'logout.php',
        '' => 'index.php',
        '/' => 'index.php'
    ];

    // Special API endpoints
    if ($path === '/redeem') {
        $file = "{$documentRoot}/redeem.php";
        if (!is_readable($file)) {
            throw new RuntimeException("API endpoint not accessible: {$path}");
        }
        require $file;
        exit;
    }

    // Handle bottle routes
    if (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
        $_GET['id'] = filter_var($matches[1], FILTER_VALIDATE_INT);
        if ($_GET['id'] === false) {
            throw new RuntimeException('Invalid bottle ID');
        }
        $file = "{$documentRoot}/bottle.php";
        if (!is_readable($file)) {
            throw new RuntimeException("Bottle handler not accessible");
        }
        require $file;
        exit;
    }

    // Handle static files first
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $path)) {
        return false;
    }

    // Handle defined routes
    if (isset($routes[$path])) {
        $file = "{$documentRoot}/{$routes[$path]}";
        if (!is_readable($file)) {
            throw new RuntimeException("Route file not accessible: {$path}");
        }
        require $file;
        exit;
    }

    // Try PHP file with extension
    $phpFile = "{$documentRoot}{$path}.php";
    if (is_readable($phpFile)) {
        require $phpFile;
        exit;
    }

    // If no route matches, show 404
    error_log("[Router] No matching route for: {$path}");
    header('HTTP/1.0 404 Not Found');
    require "{$documentRoot}/404.php";
    exit;

    // Handle static files
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $path)) {
        return false;
    }
} catch (Throwable $e) {
    error_log("[Router] Error: " . $e->getMessage());
    error_log("[Router] File: " . $e->getFile() . " Line: " . $e->getLine());
    error_log("[Router] Stack trace: " . $e->getTraceAsString());

    header('HTTP/1.0 500 Internal Server Error');
    if (ini_get('display_errors')) {
        die('500 Internal Server Error: ' . $e->getMessage());
    } else {
        die('500 Internal Server Error');
    }
}