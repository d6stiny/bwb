<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Handle root path
if ($path === '/' || $path === '') {
    if (file_exists(__DIR__ . '/index.html')) {
        return false; // Serve index.html
    } elseif (file_exists(__DIR__ . '/index.php')) {
        require __DIR__ . '/index.php';
        return true;
    }
}

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

$exactFile = __DIR__ . $path;
if (file_exists($exactFile)) {
    return false;
}

$phpFile = __DIR__ . $path . '.php';
if (file_exists($phpFile)) {
    require $phpFile;
    return true;
}

// 404 if no match
header("HTTP/1.0 404 Not Found");
echo "404 Not Found";