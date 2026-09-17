<?php

namespace app\EventSystem\Listeners;

use app\EventSystem\EventInterface;
use app\EventSystem\ListenerInterface;

class SendEmailListener implements ListenerInterface {
    public function handle(EventInterface $event): void {
        $data = $event->getPayload();
        echo "[SendEmailListener] Correo enviado a: " . $data['email'] . PHP_EOL;
    }
}