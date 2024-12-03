<?php
// Include helpers first
require_once __DIR__ . '/helpers.php';

// Get the request URI and remove any query strings
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Get the project directory name 
$projectDir = '/bwb';
$path = str_replace($projectDir, '', $requestUri);

// Start output buffering
ob_start();

if (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    require __DIR__ . '/bottle.php';
}

// Handle special routes first
if ($path === '/dashboard') {
    require __DIR__ . '/dashboard.php';
} elseif (preg_match('/^\/bottles\/(\d+)$/', $path, $matches)) {
    $_GET['id'] = $matches[1];
    require __DIR__ . '/bottle.php';
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

// Get the buffered content
$content = ob_get_clean();

// Check if the response is HTML
if (strpos($content, '<head>') !== false) {
    // Insert globals.css before the closing head tag
    $content = str_replace(
        '</head>',
        '    <link rel="stylesheet" href="/css/globals.css">' . PHP_EOL . '</head>',
        $content
    );
}

// Output the modified content
echo $content;
return true;