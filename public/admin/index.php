<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config/bootstrap.php';
require_once BASE_PATH . '/config/admin_routes.php';

$router = new Router();
register_admin_routes($router);

$path = current_path();
$path = preg_replace('#^/admin#', '', $path);
if ($path === '' ) {
    $path = '/';
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
