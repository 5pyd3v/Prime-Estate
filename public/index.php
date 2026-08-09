<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/bootstrap.php';
require_once BASE_PATH . '/config/routes.php';

$router = new Router();
register_public_routes($router);
$router->dispatch($_SERVER['REQUEST_METHOD'], current_path());
