<?php

namespace app\Observers\Domain;

use app\Observers\ObserverInterface;

class ReservaLoggerObserver implements ObserverInterface {
    public function update($data): void {

        $logDir = dirname(__DIR__, 3) . '/logs'; // Ajusta la ruta al directorio de logs
        $logFile = $logDir . '/request2.log';

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

    }
}
