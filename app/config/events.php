<?php

// Mapa de eventos y sus respectivos listeners
// Este archivo define los eventos que se pueden disparar en la aplicación y los listeners que deben ejecutarse cuando se disparan esos eventos.

return [
    // 'user.logged_in' => [
    //     [
    //         'class' => \app\Listeners\LogLoginListener::class,
    //         'priority' => 10,
    //     ]
    // ],

    'reservation.created' => [
        [
            'class' => \app\EventSystem\Listeners\SendEmailListener::class,
            'priority' => 20,
            'condition' => fn($data) => $data['pais'] === 'Mexico',
        ],
        [
            'class' => \app\EventSystem\Listeners\NotifyCRMListener::class,
            'priority' => 10,
            'condition' => fn($data) => $data['total'] > 5000,
        ],
    ],
];
