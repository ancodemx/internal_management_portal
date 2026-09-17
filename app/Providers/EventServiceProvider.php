<?php

namespace app\Providers;

use app\EventSystem\EventDispatcher;

class EventServiceProvider {
    public static function register(): void {

        $events = require dirname(__DIR__, 2) . '/app/config/events.php';

        EventDispatcher::register($events);
    }
}