<?php
declare(strict_types=1);

require_once __DIR__ . '/env.php';

final class DB
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');
            $name = env('DB_NAME', 'realestate_cms');
            $charset = env('DB_CHARSET', 'utf8mb4');

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

            try {
                self::$instance = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                error_log('DB connection failed: ' . $e->getMessage());
                if (env('APP_DEBUG', false) === true) {
                    throw $e;
                }
                http_response_code(500);
                require dirname(__DIR__) . '/views/pages/500.php';
                exit;
            }
        }

        return self::$instance;
    }
}
