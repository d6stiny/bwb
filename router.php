<?php
// Get the request URI and remove any query strings
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Get the project directory name
$projectDir = '/bwb'; // Update this to your project folder name in xampp/htdocs
$path = str_replace($projectDir, '', $requestUri);

// Handle /dashboard route
if ($path === '/dashboard') {
    require __DIR__ . '/dashboard.php';
    return true;
}

// Handle /bottles/:id route
if (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    require __DIR__ . '/bottle.php';
    return true;
}

// Handle login/logout routes
if ($path === '/login') {
    require __DIR__ . '/login.php';
    return true;
}

if ($path === '/logout') {
    require __DIR__ . '/logout.php';
    return true;
}

// Handle root path
if ($path === '/' || $path === '') {
    if (file_exists(__DIR__ . '/index.html')) {
        return false;
    }
    require __DIR__ . '/index.html';
    return true;
}

// Allow direct access to static files
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html)$/', $path)) {
    return false;
}

// Check for PHP file
$phpFile = __DIR__ . $path . '.php';
if (file_exists($phpFile)) {
    require $phpFile;
    return true;
}

// 404 if no match
header("HTTP/1.0 404 Not Found");
echo "404 Not Found";