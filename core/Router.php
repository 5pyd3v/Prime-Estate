<?php
declare(strict_types=1);

final class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void
    {
        $this->routes['GET'][] = [$pattern, $handler];
    }

    public function post(string $pattern, callable $handler): void
    {
        $this->routes['POST'][] = [$pattern, $handler];
    }

    public function any(string $pattern, callable $handler): void
    {
        $this->get($pattern, $handler);
        $this->post($pattern, $handler);
    }

    public function dispatch(string $method, string $path): void
    {
        $path = '/' . trim(rawurldecode(parse_url($path, PHP_URL_PATH) ?: '/'), '/');
        if ($path === '') {
            $path = '/';
        }

        foreach ($this->routes[$method] ?? [] as [$pattern, $handler]) {
            $params = $this->match($pattern, $path);
            if ($params !== null) {
                call_user_func($handler, $params);
                return;
            }
        }

        abort(404);
    }

    private function match(string $pattern, string $path): ?array
    {
        $pattern = '/' . trim($pattern, '/');
        if ($pattern === '/') {
            return $path === '/' ? [] : null;
        }

        $paramNames = [];
        $regex = preg_replace_callback('/:([a-zA-Z_]+)/', function ($m) use (&$paramNames) {
            $paramNames[] = $m[1];
            return '([^/]+)';
        }, $pattern);

        if (!preg_match('#^' . $regex . '$#', $path, $matches)) {
            return null;
        }

        array_shift($matches);
        return array_combine($paramNames, array_map('rawurldecode', $matches));
    }
}
