<?php

namespace app\Observers;

interface ObserverInterface {
    public function update($data): void;
}