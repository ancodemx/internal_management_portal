<?php

namespace app\Middleware;

use app\Utils\JwtService as Jwt;

use app\Middleware\Kernel\BeforeMiddlewareInterface;

class JwtMiddleware implements BeforeMiddlewareInterface {

    /**
     * Duración del token en segundos.
     * Debe coincidir con el valor usado en SetSessionUseCase (15 * 60).
     * Configurable vía JWT_TTL en el archivo .env.
     */
    private const TOKEN_TTL = 900; // 15 minutos

    /**
     * Ventana de refresh proactivo: si al token le quedan menos de estos
     * segundos, se renueva en silencio sin esperar a que expire.
     */
    private const REFRESH_AHEAD = 300; // 5 minutos

    private Jwt $jwtService;

    public function __construct() {
        $this->jwtService = new Jwt();
    }

    public function handle(callable $next): void
    {
        if ($this->isStaticAssetRequest()) {
            $next();
            return;
        }

        $token = $_SESSION['token'] ?? null;

        if (!$token) {
            $this->unauthorized();
            return;
        }

        $payload = $this->jwtService->decode($token);

        if ($payload) {
            // Token válido — refresh proactivo si expira en menos de REFRESH_AHEAD segundos
            $remaining = ($payload['exp'] ?? 0) - time();
            if ($remaining < self::REFRESH_AHEAD) {
                $newToken = $this->jwtService->refreshToken($payload, self::TOKEN_TTL);
                if ($newToken) {
                    $_SESSION['token'] = $newToken;
                    $payload = $this->jwtService->decode($newToken);
                }
            }
        } else {
            // decode() falló — probablemente el token expiró
            $payload = $this->jwtService->decodeAllowExpired($token);

            if (!$payload) {
                // Firma inválida o token malformado: forzar logout
                $this->unauthorized();
                return;
            }

            // Token expirado pero con firma válida → renovar con TTL completo
            $newToken = $this->jwtService->refreshToken($payload, self::TOKEN_TTL);

            if (!$newToken) {
                $this->unauthorized();
                return;
            }

            $_SESSION['token'] = $newToken;
            $payload = $this->jwtService->decode($newToken);
        }

        $_SERVER['JWT_PAYLOAD'] = $payload;

        $next();
    }

    /**
     * Termina la petición sin autorización.
     * - Navegación normal  → redirect al login (el browser muestra la página de login).
     * - Petición AJAX/XHR  → 401 JSON (el JS puede redirigir o mostrar alerta).
     */
    private function unauthorized(): void
    {
        if ($this->isAjaxRequest()) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Sesión expirada', 'session_on' => false]);
        } else {
            $loginUrl = defined('URL_PATH') ? URL_PATH . 'Login' : '/Login';
            header('Location: ' . $loginUrl);
        }
        exit;
    }

    private function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function isStaticAssetRequest(): bool
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $path = parse_url($requestUri, PHP_URL_PATH) ?: '';

        if ($path === '') {
            return false;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, [
            'css', 'js', 'map',
            'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico',
            'woff', 'woff2', 'ttf', 'eot', 'otf'
        ], true);
    }

}