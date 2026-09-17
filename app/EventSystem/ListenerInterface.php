<?php

namespace app\EventSystem;

interface ListenerInterface {
    public function handle(EventInterface $event): void;
}
