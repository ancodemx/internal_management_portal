<?php

namespace app\Providers;

use app\Observers\ObserverManager;
use app\Observers\Domain\ReservaLoggerObserver;
// use app\observers\ReservaEmailObserver;

/**
 * ObserverServiceProvider
 *
 * Registra los observadores para eventos específicos.
 * 
 * Aquí se registran todos los observers definidos (por ejemplo: para user.login, user.deleted, reserva.creada, etc.)
 * Pero solo se ejecutan si tú haces: ObserverManager::notify('user.login', $data);
 * 
 * ¿Es un problema que todos se registren?
 * No, porque los observers no se ejecutan hasta que se llama a ObserverManager::notify().
 * 
 * El registro es liviano (solo se guardan los nombres de clases).
 */

class ObserverServiceProvider {
    public static function register(): void {
        ObserverManager::register('user.login', [
            ReservaLoggerObserver::class,
            // ReservaEmailObserver::class,
        ]);

        // Puedes agregar más:
        // ObserverManager::register('user.deleted', [...]);
    }
}
