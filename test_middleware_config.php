<?php
// Script de prueba para verificar la configuración de middlewares

require_once 'app/Middleware/Kernel/MiddlewareHandler.php';

use app\Middleware\Kernel\MiddlewareHandler;

echo "=== Prueba de configuración de middlewares ===\n";

// Prueba 1: Login@index (debe ser público)
$middlewares1 = MiddlewareHandler::resolveMiddlewareList('Login', 'index');
echo "Login@index middlewares: " . print_r($middlewares1, true) . "\n";

// Prueba 2: Login@logIn (debe ser público)
$middlewares2 = MiddlewareHandler::resolveMiddlewareList('Login', 'logIn');
echo "Login@logIn middlewares: " . print_r($middlewares2, true) . "\n";

// Prueba 3: User@index (debe tener middlewares globales)
$middlewares3 = MiddlewareHandler::resolveMiddlewareList('User', 'index');
echo "User@index middlewares: " . print_r($middlewares3, true) . "\n";

echo "=== Fin de pruebas ===\n";
