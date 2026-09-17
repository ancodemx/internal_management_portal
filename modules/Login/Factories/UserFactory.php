<?php

namespace modules\Login\Factories;

class UserFactory
{
    /**
     * Crea un molde con los datos del usuario.
     *
     * @param array $user_data Datos del usuario.
     * @param array $overrides Datos adicionales para sobreescribir o agregar.
     *              Útil para agregar campos opcionales o personalizados.
     * @return array Array con los datos formateados.
     */
    public static function make(array $user_data, array $overrides = []): array
    {
        $base = [
            'id'         => $user_data['id'] ?? null,
            'profile_id' => $user_data['profile_id'] ?? null,
            'full_name'  => $user_data['full_name'] ?? null,
            'first_name' => $user_data['first_name'] ?? null,
            'last_name'  => $user_data['last_name'] ?? null,
            'middle_name'=> $user_data['middle_name'] ?? null,
            'username'   => $user_data['username'] ?? null,
            'status'     => $user_data['status'] ?? null,
        ];
        
        return array_merge($base, $overrides);
    }
}