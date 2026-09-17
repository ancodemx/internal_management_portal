<?php

return [
    'global' => [
        \app\Middleware\JwtMiddleware::class,
        // \app\Middleware\ExecutionTimeMiddleware ::class,
        // \app\Middleware\SessionPreserverMiddleware::class,
        \app\Middleware\CheckAuthMiddleware::class,
        // Agrega más middlewares globales aquí
    ],
    'controllers' => [
        // 'Login' => [],
        // Otros controladores...
    ],
    'methods' => [
        // 'User@publicInfo' => [], // sin auth
        // 'User@index' => [],
        'Login@index' => [], // público - página de login
        'Login@logIn' => [], // público - procesar login
    ]
];

