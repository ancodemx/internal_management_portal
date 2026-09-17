<?php

namespace app\EventSystem;

use app\EventSystem\ListenerInterface;

/**
 * Clase EventDispatcher
 *
 * Esta clase se encarga de registrar y despachar eventos a sus respectivos oyentes.
 * Permite definir condiciones y prioridades para la ejecución de los oyentes.
 * Prioridad: Ejecutar listeners en orden definido
 * Condición: Ejecutar listeners solo si se cumple una condición específica
 */
class EventDispatcher {
    protected static array $listeners = [];

    public static function register(array $map): void {
        foreach ($map as $eventName => $listenerDefs) {
            foreach ($listenerDefs as $listener) {
                $entry = [
                    'class' => $listener['class'] ?? $listener,
                    'priority' => $listener['priority'] ?? 0,
                    'condition' => $listener['condition'] ?? null,
                ];
                self::$listeners[$eventName][] = $entry;
            }

            // Orden por prioridad
            usort(self::$listeners[$eventName], fn($a, $b) => $b['priority'] <=> $a['priority']);
        }
    }

    public static function dispatch(string $eventName, EventInterface $event): void {
        foreach (self::$listeners[$eventName] ?? [] as $listenerMeta) {
            $payload = $event->getPayload();

            if (is_callable($listenerMeta['condition']) && !$listenerMeta['condition']($payload)) {
                continue;
            }

            $listener = new $listenerMeta['class'];
            if ($listener instanceof ListenerInterface) {
                $listener->handle($event);
            }
        }
    }
}


