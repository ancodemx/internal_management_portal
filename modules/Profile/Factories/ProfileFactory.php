<?php

namespace modules\Profile\Factories;

use app\config\Maps\PermissionMap;

use app\Utils\TransformUtils;

use app\Exceptions\ResponseException;

class ProfileFactory
{
    /**
     * Crea un molde con los datos del perfil.
     *
     * @param array $profile_data   Datos del perfil.
     * @param array $overrides      Datos adicionales para sobreescribir o agregar.
     *                              Útil para agregar campos opcionales o personalizados.
     * @return array Array con los datos formateados.
     */
    public static function make(array $profile_data, array $overrides = []): array
    {
        // llamar build
        $permissions = self::build($profile_data['permissions'] ?? [], $profile_data['view_modules'] ?? []);

        $base = [
            'id'               => $profile_data['profile_id'] ?? null,
            'profile_name'     => $profile_data['profile_name'] ?? null,
            'description_name' => $profile_data['description'] ?? null,
            // 'json_items'       => $permissions['items'] ?? null,
            'json_items'       => TransformUtils::convertNumericValuesToInt($permissions['items'] ?? null),
            'json_permissions' => $permissions['permissions'] ?? null,
            'user_action_id'   => $profile_data['user_action_id'] ?? null
        ];
        
        return array_merge($base, $overrides);
    }


    public static function build(array $permissions, array $viewModules): array
    {
        $map = PermissionMap::MAP;
        $mapValues = array_values($map);
        $items = [];
        $perms = [];

        // Validar items contra los valores de MAP
        foreach ($viewModules as $item) {
            if (!in_array($item, $mapValues, false)) {
                // trigger_error("Discrepancia: item '$item' no existe en MAP", E_USER_WARNING);
                throw new ResponseException("Discrepancia en items.", 0, ["alert_type" => "error"], 400, false);

                // Aquí podemos mandar a un log que estan intentando acceder a un item no permitido
            } else {
                $items[] = $item;
            }
        }

        // Validar permisos contra los valores de MAP
        foreach ($permissions as $permArray) {
            if (is_array($permArray)) {
                foreach ($permArray as $perm) {
                    if (is_string($perm) || is_int($perm)) {
                        if (!in_array($perm, $mapValues, true)) {
                            throw new ResponseException("Discrepancia en permisos.", 0, ["alert_type" => "error"], 400, false);

                            // Aquí podemos mandar a un log que estan intentando acceder a un permiso no permitido
                        } else {
                            $perms[] = $perm;
                        }
                    }
                }
            }
        }

        return [
            'items' => $items,
            'permissions' => $perms
        ];
    }
}