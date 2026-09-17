<?php

namespace modules\User\Factories;

use app\Utils\TransformUtils;

class UserFactory
{
    /**
     * Crea un molde con los datos del usuario.
     *
     * @param array $user_data   Datos del usuario.
     * @param array $overrides   Datos adicionales para sobreescribir o agregar.
     *                           Útil para agregar campos opcionales o personalizados.
     * @return array Array con los datos formateados.
     */
    public static function make(array $user_data, array $overrides = []): array
    {
        // Verificar si json_categories es un array, si es un array pasa, pero si viene como json convertir a array
        if (isset($user_data['json_categories']) && is_string($user_data['json_categories'])) {
            $user_data['json_categories'] = json_decode($user_data['json_categories'], true);
        }

        $base = [
            'id'               => $user_data['user_id'] ?? null,
            'first_name'       => $user_data['first_name'] ?? null,
            'last_name'        => $user_data['last_name'] ?? null,
            'middle_name'      => $user_data['middle_name'] ?? null,
            'email'            => $user_data['email'] ?? null,
            'username'         => $user_data['username'] ?? null,
            'password'         => $user_data['password'] ?? null,
            'confirm_password' => $user_data['confirm_password'] ?? null,
            'profile_id'       => $user_data['profile_id'] ?? null,
            'json_categories'  => TransformUtils::convertNumericValuesToInt($user_data['json_categories'] ?? []),
            'user_action_id'   => $user_data['user_action_id'] ?? null
        ];
        
        return array_merge($base, $overrides);
    }
}