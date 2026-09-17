<?php

namespace app\Middleware\Kernel;

interface BeforeMiddlewareInterface {
    public function handle(callable $next): void;
}