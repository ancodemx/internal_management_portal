<?php

namespace app\EventSystem\Events;

use app\EventSystem\EventInterface;


/*
Estos eventos son específicos para la creación de reservas

¿Cuándo conviene tener una clase por evento?
Ventajas:

- Si cada evento puede tener lógica propia, validaciones, métodos adicionales o propiedades específicas.
- Si quieres aprovechar el tipado fuerte y la autocompletación para cada tipo de evento.
- Si en el futuro cada evento puede evolucionar de forma distinta.
*/

class ReservationCreatedEvent implements EventInterface {
    public function __construct(protected array $payload) {}

    public function getPayload(): mixed {
        return $this->payload;
    }
}