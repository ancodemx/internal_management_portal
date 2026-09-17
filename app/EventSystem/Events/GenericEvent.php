<?php

namespace app\EventSystem\Events;

use app\EventSystem\EventInterface;

/*
¿Cuándo conviene usar un solo evento genérico?
Ventajas:

- Menos archivos y clases.
- Simplicidad si solo transportas datos y no necesitas lógica específica por evento.
*/

class GenericEvent implements EventInterface
{
    protected array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }
}