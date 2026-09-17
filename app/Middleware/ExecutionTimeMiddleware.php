<?php

namespace app\Middleware;

use app\Middleware\Kernel\TerminableMiddlewareInterface;

class ExecutionTimeMiddleware implements TerminableMiddlewareInterface
{
    private float $startTime;

    public function __construct()
    {
        $this->startTime = microtime(true); // Marca el inicio
    }

    public function terminate($controller, $method, $parameters): void
    {
        $user = !empty($_SESSION["user_data"]['username']) ? $_SESSION["user_data"]['username'] : 'default_user';
        // $user = $_SESSION["user_data"]['username'] ?? 'default_user';

        $endTime = microtime(true); // Marca el final
        $executionTime = round($endTime - $this->startTime, 4);

        $logMessage = "[EXECUTION TIME] User: {$user}, {$controller}::{$method} -> {$executionTime} sec" . PHP_EOL;

        $logDir = dirname(__DIR__, 2) . '/logs'; // Ajusta la ruta al directorio de logs
        $logFile = $logDir . '/request3.log';

        // Crear la carpeta si no existe
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
