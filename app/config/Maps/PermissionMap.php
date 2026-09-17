<?php
namespace App\config\Maps;

/*
✅ Ventajas:

Estructura limpia y mantenible.
Puedes tener varios Maps sin contaminar config/.
Posibilidad de agregar métodos estáticos (PermissionMap::has($key)).
*/

class PermissionMap {
    /*
    Este MAP contiene los permisos disponibles en la aplicación, es inmutable.
    Para que funcione correctamente deben concordar con los permisos en la base de datos.
    */
    public const MAP = [
        'view_module_profile' => 2,
        'create_profile'      => 'create_profile',
        'edit_profile'        => 'edit_profile',
        'delete_profile'      => 'delete_profile',
        'view_module_user'    => 3,
        'create_user'         => 'create_user',
        'edit_user'           => 'edit_user',
        'delete_user'         => 'delete_user',
    ];


    // Métodos estáticos
    // Son metodos de ejemplos de lo que se puede hacer
    /*
    public static function has(string $key): bool {
        return isset(self::MAP[$key]);
    }

    public static function getValue(string $key): ?int {
        return self::MAP[$key] ?? null;
    }
        */
}