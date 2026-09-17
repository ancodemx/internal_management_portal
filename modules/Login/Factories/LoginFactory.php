<?php

namespace modules\Login\Factories;

class LoginFactory
{
    /**
     * Crea un molde con los datos de inicio de sesión.
     *
     * @param array $post_data Datos de inicio de sesión.
     * @param array $overrides Datos adicionales para sobreescribir o agregar.
     *              Útil para agregar campos opcionales o personalizados.
     * @return array Array con los datos formateados.
     */
    public static function make(array $post_data, array $overrides = []): array
    {
        $base = [
            'username' => $post_data['username'] ?? null,
            'password' => $post_data['password'] ?? null,
        ];
        
        return array_merge($base, $overrides);
    }
}