<?php

namespace app\Utils;

use app\Exceptions\ResponseException;

class PasswordUtils {

    /**
     * Hash a password using bcrypt.
     *
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verify a password against a hash.
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    /**
     * Generate a random password.
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomPassword(int $length = 12): string {
        try {
            if ($length < 8)
                throw new ResponseException("La longitud de la contraseña debe ser al menos 8 caracteres.", 0, ["alert_type" => "error"], 400, false);

            return bin2hex(random_bytes($length / 2));
        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al generar contraseña aleatoria: " . $e->getMessage(), 0, ["alert_type" => "error"], 500, false);
        }
    }

    /**
     * Validar la fortaleza de una contraseña.
     *
     * @param string $password
     * @return bool
     */
    public static function validatePasswordStrength(string $password): bool {
        // Minimo 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    /**
     * Validar longitud de una contraseña.
     *
     * @return bool
     */
    public static function validatePasswordLength(string $password, int $minLength = 8): bool {
        // Verifica si la longitud de la contraseña es mayor o igual al mínimo requerido
        return strlen($password) >= $minLength;
    }
}