<?php

namespace app\Middleware\Kernel;

interface TerminableMiddlewareInterface {
    public function terminate($controller, $method, $parameters): void;
}
