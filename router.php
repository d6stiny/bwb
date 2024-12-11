<?php

// Get the request URI and remove any query strings
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dynamically determine the project directory
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$projectDir = $scriptDir !== '/' ? $scriptDir : '';

// Clean the path
$path = str_replace($projectDir, '', $requestUri);

// Handle API endpoints first
if ($path === '/redeem') {
    require __DIR__ . '/redeem.php';
    return true;
}

// Handle bottle routes
if (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    require __DIR__ . '/bottle.php';
    return true;
}

// Handle other routes
if ($path === '/dashboard') {
    require __DIR__ . '/dashboard.php';
} elseif ($path === '/login') {
    require __DIR__ . '/login.php';
} elseif ($path === '/logout') {
    require __DIR__ . '/logout.php';
} elseif ($path === '/' || $path === '') {
    require __DIR__ . '/index.php';
} elseif (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $path)) {
    return false;
} else {
    $phpFile = __DIR__ . $path . '.php';
    if (file_exists($phpFile)) {
        require $phpFile;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        return true;
    }
}

return true;