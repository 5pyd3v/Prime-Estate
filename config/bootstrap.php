<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once __DIR__ . '/env.php';

error_reporting(E_ALL);
if (env('APP_DEBUG', false) === true) {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
}
ini_set('log_errors', '1');
ini_set('error_log', BASE_PATH . '/storage_error.log');

spl_autoload_register(function (string $class): void {
    foreach (['/core/', '/models/'] as $dir) {
        $file = BASE_PATH . $dir . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/db.php';
require_once BASE_PATH . '/core/helpers.php';

set_exception_handler(function (Throwable $e): void {
    error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    if (!headers_sent()) {
        http_response_code(500);
    }
    if (env('APP_DEBUG', false) === true) {
        echo '<pre style="padding:2rem;font-family:monospace;white-space:pre-wrap;">' . htmlspecialchars((string) $e) . '</pre>';
    } else {
        require BASE_PATH . '/views/pages/500.php';
    }
    exit;
});

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => (int) env('SESSION_LIFETIME', 7200),
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (($_SERVER['HTTPS'] ?? '') === 'on'),
    ]);
    session_name((string) env('SESSION_NAME', 'recms_session'));
    session_start();
}

Settings::boot();
