<?php
// Get the request URI and remove any query strings
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the project directory name from the path if it exists
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($basePath, '', $requestUri);

// Handle /bottles/:id route
if (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    require __DIR__ . '/bottle.php';
    return true;
}

// Handle root path
if ($path === '/' || $path === '') {
    if (file_exists(__DIR__ . '/index.html')) {
        return false; // Let Apache serve static files
    } elseif (file_exists(__DIR__ . '/index.php')) {
        require __DIR__ . '/index.php';
        return true;
    }
}

// Allow direct access to static files
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html)$/', $path)) {
    return false; // Let Apache handle static files
}

// Check for exact file match
$exactFile = __DIR__ . $path;
if (file_exists($exactFile)) {
    return false; // Let Apache serve the file
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