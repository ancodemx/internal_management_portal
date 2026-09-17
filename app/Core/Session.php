<?php

namespace app\Core;

class Session
{
    /**
     * Inicia sesión si no está activa
     */
    protected static function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Obtener un valor de la sesión
     */
    public static function get(string $key, $default = null)
    {
        self::ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Poner un valor en la sesión (sobrescribe completamente)
     */
    public static function put(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Fusiona el nuevo valor con el valor anterior (solo si ambos son arrays)
     */
    public static function merge(string $key, array $value): void
    {
        self::ensureStarted();
        $original = self::get($key, []);

        if (!is_array($original)) {
            $original = [];
        }

        $_SESSION[$key] = array_merge($original, $value);
    }

    /**
     * Elimina un valor de la sesión
     */
    public static function forget(string $key): void
    {
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    /**
     * Agrega un valor a un array en la sesión
     */
    public static function push(string $key, $value): void
    {
        self::ensureStarted();
        if (!isset($_SESSION[$key]) || !is_array($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }
        $_SESSION[$key][] = $value;
    }

    /**
     * Mantiene solo las claves permitidas en la sesión
     * @param array $allowedKeys Claves que se deben mantener
     */
    public static function keepOnly(array $allowedKeys): void
    {
        self::ensureStarted();
        foreach ($_SESSION as $key => $value) {
            if (!in_array($key, $allowedKeys)) {
                unset($_SESSION[$key]);
            }
        }
    }

    /**
     * Limpia toda la sesión
     */
    public static function flush(): void
    {
        self::ensureStarted();
        $_SESSION = [];
        session_destroy();
    }
}



/*

// ✅ 1. PUT: Guardar un array completo
Session::put('usuario', [
    'nombre' => 'Alfonso',
    'rol' => 'admin'
]);

// ✅ 2. GET: Leer el valor de sesión
$usuario = Session::get('usuario');
echo "<h3>GET usuario:</h3>";
print_r($usuario);

// ✅ 3. MERGE: Agregar nuevas claves sin perder lo anterior
Session::merge('usuario', [
    'email' => 'alfonso@correo.com',
    'rol' => 'superadmin' // sobreescribe
]);
echo "<h3>MERGE usuario (con email y nuevo rol):</h3>";
print_r(Session::get('usuario'));

// ✅ 4. PUSH: Agregar un elemento a un array de sesión (tipo lista)
Session::push('notificaciones', 'Tu sesión ha iniciado.');
Session::push('notificaciones', 'Tienes una nueva reserva.');

echo "<h3>PUSH notificaciones:</h3>";
print_r(Session::get('notificaciones'));

// ✅ 5. FORGET: Borrar un valor de la sesión
Session::forget('usuario');
echo "<h3>FORGET usuario:</h3>";
var_dump(Session::get('usuario', 'No encontrado'));

// ✅ 6. KEEP ONLY: Mantener solo las claves permitidas
Session::keepOnly(['data_user', 'menu']);
echo "<h3>KEEP ONLY data_user y menu:</h3>";
print_r(Session::get('data_user'));
print_r(Session::get('menu'));

// ✅ 7. FLUSH: Limpiar toda la sesión (usuario + notificaciones + todo)
Session::flush();
echo "<h3>FLUSH (todo eliminado):</h3>";
print_r($_SESSION);

*/
