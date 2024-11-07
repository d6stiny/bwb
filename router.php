<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $file = __DIR__ . $path . '.php';
    
    if (file_exists($file)) {
        require $file;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}