<?php
namespace App;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $pattern, callable|array $handler): void { $this->routes['GET'][$pattern] = $handler; }
    public function post(string $pattern, callable|array $handler): void { $this->routes['POST'][$pattern] = $handler; }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        foreach ($this->routes[$method] as $pattern => $handler) {
            $params = [];
            $regex = $this->toRegex($pattern, $params);
            if (preg_match($regex, $uri, $matches)) {
                $args = [];
                foreach ($params as $name) { $args[$name] = $matches[$name] ?? null; }
                if (is_array($handler)) {
                    [$class, $methodName] = $handler;
                    $controller = new $class();
                    echo $controller->$methodName(...array_values($args));
                } else {
                    echo $handler(...array_values($args));
                }
                return;
            }
        }
        http_response_code(404);
        echo View::render('errors/404', ['uri' => $uri]);
    }

    private function toRegex(string $pattern, ?array &$params = []): string
    {
        $params = [];
        $regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', function ($m) use (&$params) {
            $params[] = $m[1];
            return '(?P<' . $m[1] . '>[^/]+)';
        }, $pattern);
        return '#^' . $regex . '$#u';
    }
}
