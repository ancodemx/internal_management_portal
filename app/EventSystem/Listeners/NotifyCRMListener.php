<?php

namespace app\EventSystem\Listeners;

use app\EventSystem\EventInterface;
use app\EventSystem\ListenerInterface;

class NotifyCRMListener implements ListenerInterface {
    public function handle(EventInterface $event): void {
        $data = $event->getPayload();
        echo "[NotifyCRMListener] Notificación enviada al CRM: " . json_encode($data) . PHP_EOL;
    }
}