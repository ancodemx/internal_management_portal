<?php

namespace app\Middleware;

use app\Middleware\Kernel\TerminableMiddlewareInterface;

use app\Core\Session;

class SessionPreserverMiddleware implements TerminableMiddlewareInterface
{
    public function __construct()
    {
        
    }

    public function terminate($controller, $method, $parameters): void
    {
        Session::keepOnly(['controlador', 'metodo','token','user_data','profile_menu','permissions']);
        echo "[SessionPreserverMiddleware] Sesión preservada con los datos necesarios." . PHP_EOL . "Controlador: $controller, Método: $method, Parámetros: " . json_encode($parameters) . PHP_EOL;
    }
}
