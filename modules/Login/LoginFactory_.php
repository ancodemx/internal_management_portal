<?php

namespace modules\Login;

/**
 * Clase para crear DTOs (Data Transfer Objects) para el inicio de sesión.
 * Esta clase proporciona métodos estáticos para transformar datos en un formato adecuado para su uso en la aplicación.
 */

class LoginFactory
{
    /**
     * Crea un molde con los datos de inicio de sesión.
     *
     * @param array $login_data Datos de inicio de sesión.
     * @return array Array con los datos formateados.
     */
    public static function fromLoginData(array $post_data): array
    {
        return [
            'username' => $post_data['username'] ?? null,
            'password' => $post_data['password'] ?? null,
        ];
    }


    /**
     * Crea un molde con los datos del usuario.
     *
     * @param array $user_data Datos del usuario.
     * @return array Array con los datos formateados.
     */
    public static function fromUserData(array $user_data, array $overrides = []): array
    {
        $base = [
            'id'         => $user_data['id'] ?? null,
            'profile_id' => $user_data['id_perfil'] ?? null,
            'full_name'  => $user_data['nombre_completo'] ?? null,
            'first_name' => $user_data['nombre'] ?? null,
            'last_name'  => $user_data['apellido_paterno'] ?? null,
            'middle_name'=> $user_data['apellido_materno'] ?? null,
            'username'   => $user_data['usuario'] ?? null,
            'status'     => $user_data['estatus'] ?? null,
        ];
        return array_merge($base, $overrides);
    }
}