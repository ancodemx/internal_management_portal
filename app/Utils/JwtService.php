<?php

namespace app\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// use app\Exceptions\ResponseService;

class JwtService
{
    protected $secret;

    public function __construct()
    {
        // $this->secret = $_ENV['JWT_SECRET'] ?? 'clave_secreta_default';
        $this->secret = $_ENV['JWT_SECRET'];
    }
    

    public function encode(array $payload, int $exp = 3600): string
    {
        $payload['iat'] = time();
        $payload['exp'] = $payload['iat'] + $exp;

        return JWT::encode($payload, $this->secret, 'HS256');
    }


    public function decode(string $jwt): ?array
    {
        try {
            return (array) JWT::decode($jwt, new Key($this->secret, 'HS256'));
        } catch (\Exception $e) {
            // error_log("JWT Decode Error: " . $e->getMessage());
            return null;
        }
    }

    public function isExpired(array $payload): bool
    {
        return isset($payload['exp']) && $payload['exp'] < time();
    }


    // public function refreshToken(string $jwt): ?array
    public function refreshToken($payload, int $exp = 900): ?string
    {
        // Validar que el payload tenga datos confiables
        // if (!is_array($payload) || !isset($payload['user_id']) || !isset($payload['profile_id'])) {
        if (!is_array($payload)) {
            return null;
        }

        // Regenerar el payload, sin campos no deseados
        unset($payload['exp'], $payload['iat']);

        return $this->encode($payload, $exp);
    }


    public function decodeAllowExpired(string $jwt): ?array
    {
        try {
            // Intentar decode normal
            return (array) JWT::decode($jwt, new Key($this->secret, 'HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token expirado: decodificamos manualmente el payload
            $parts = explode('.', $jwt);
            if (count($parts) !== 3) return null;

            $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($parts[1]));

            return (array) $payload;
        } catch (\Exception $e) {
            return null;
        }
    }
}