<?php

namespace app\Middleware\Kernel;

use app\Middleware\Kernel\BeforeMiddlewareInterface;
use app\Middleware\Kernel\TerminableMiddlewareInterface;

class MiddlewareHandler 
{
    protected array $middlewares = [];
    protected array $terminableMiddlewares = [];

    public function __construct(array $middlewares = [])
    {
        $this->middlewares = $middlewares;
        $this->terminableMiddlewares = [];
        
        // Separar middlewares terminables para ejecución posterior
        foreach ($middlewares as $middlewareClass) {
            $middleware = new $middlewareClass;
            if ($middleware instanceof TerminableMiddlewareInterface) {
                $this->terminableMiddlewares[] = $middleware;
            }
        }
    }

    public function handle(callable $next): void
    {
        $this->run(0, $next);
    }

    /* private function run(int $index, callable $next) {
        if ($index < count($this->middlewares)) {
            $middleware = new $this->middlewares[$index];
            $middleware->handle(function() use ($index, $next) {
                $this->run($index + 1, $next);
            });
        } else {
            $next();
        }
    } */

    private function run(int $index, callable $next): void 
    {
        if ($index < count($this->middlewares)) {
            $middleware = new $this->middlewares[$index];

            // Solo ejecutar si implementa BeforeMiddlewareInterface
            // Los TerminableMiddleware se ejecutan después del controlador con terminate()
            if ($middleware instanceof BeforeMiddlewareInterface) {
                $middleware->handle(function () use ($index, $next) {
                    $this->run($index + 1, $next);
                });
            } else {
                // Saltar middleware si no implementa "before"
                $this->run($index + 1, $next);
            }
        } else {
            $next();
        }
    }

    public static function resolveMiddlewareList(string $controller, string $method): array
    {
        // $map = include __DIR__ . '/../Config/middleware.php';
        $map = include __DIR__ . '/../../config/middlewares.php';

        $combined = [];

        // 1. Global
        $combined = array_merge($combined, $map['global'] ?? []);

        // 2. Por controlador
        if (isset($map['controllers'][$controller])) {
            $combined = array_merge($combined, $map['controllers'][$controller]);
        }

        // 3. Por método específico (sobrescribe)
        // Si existe un método específico, lo sobrescribe completamente
        $methodKey = "{$controller}@{$method}";
        if (isset($map['methods'][$methodKey])) {
            return $map['methods'][$methodKey]; // sobrescribe completamente, no combina
        }

        return array_unique($combined);
    }

    /**
     * Ejecuta middlewares terminables (después del controlador)
     */
    public function terminate(string $controller, string $method, array $parameters = []): void
    {
        foreach ($this->terminableMiddlewares as $middleware) {
            $middleware->terminate($controller, $method, $parameters);
        }
    }
}
