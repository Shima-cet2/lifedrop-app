<?php
/**
 * Laravel Server Router
 * Used by: php -S 127.0.0.1:3000 server.php
 * Routes non-existent paths to public/index.php
 */

$publicPath = __DIR__ . '/public';
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Route everything else through index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once $publicPath . '/index.php';
