<?php
declare(strict_types=1);

// Router script for PHP's built-in dev server (php -S ... public/router.php).
// Mirrors the .htaccess rewrite rules used under Apache in production.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
$fullPath = __DIR__ . $uri;

// Serve real static files (css/js/images/uploads) directly.
if ($uri !== '/' && file_exists($fullPath) && !is_dir($fullPath)) {
    return false;
}

if (str_starts_with($uri, '/admin')) {
    require __DIR__ . '/admin/index.php';
} else {
    require __DIR__ . '/index.php';
}
