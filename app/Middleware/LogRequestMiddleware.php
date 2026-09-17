<?php

namespace app\Middleware;

use app\Middleware\Kernel\BeforeMiddlewareInterface;

class LogRequestMiddleware implements BeforeMiddlewareInterface {

    public function handle(callable $next): void {

        // $logDir = __DIR__ . '/logs';
        $logDir = dirname(__DIR__, 2) . '/logs'; // Ajusta la ruta al directorio de logs
        $logFile = $logDir . '/request.log';

        // Crear la carpeta si no existe
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $log = sprintf(
            "[%s] %s %s\n",
            date('Y-m-d H:i:s'),
            $_SERVER['REQUEST_METHOD'] ?? 'CLI',
            $_SERVER['REQUEST_URI'] ?? 'N/A'
        );

        file_put_contents($logFile, $log, FILE_APPEND);

        $next(); // continúa con la ejecución
    }
    
}
