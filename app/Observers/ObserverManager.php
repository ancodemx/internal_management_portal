<?php

namespace app\Observers;

/**
 * Clase ObserverManager
 * 
 * Administra el registro y la notificación de observadores (patrón Observer) para diferentes acciones.
 */
class ObserverManager {
    /**
     * Almacena los observadores registrados para cada acción.
     * @var array
     */
    protected static array $observers = [];

    /**
     * Registra una lista de clases observadoras para una acción específica.
     *
     * @param string $action           Nombre de la acción/evento.
     * @param array $observerClasses   Array de nombres de clases observadoras.
     */
    public static function register(string $action, array $observerClasses): void {
        self::$observers[$action] = $observerClasses;
    }

    /**
     * Notifica a todos los observadores registrados para una acción específica.
     *
     * @param string $action   Nombre de la acción/evento a notificar.
     * @param mixed $data      Datos opcionales que se pasan a los observadores.
     */
    public static function notify(string $action, $data = null): void {
        if (!isset(self::$observers[$action])) {
            return;
        }

        // Instancia y notifica a cada observador registrado para la acción
        foreach (self::$observers[$action] as $observerClass) {
            $observer = new $observerClass;
            if ($observer instanceof ObserverInterface) {
                $observer->update($data);
            }
        }
    }
}