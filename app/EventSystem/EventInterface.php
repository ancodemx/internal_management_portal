<?php

namespace app\EventSystem;

interface EventInterface {
    public function getPayload(): mixed;
}
