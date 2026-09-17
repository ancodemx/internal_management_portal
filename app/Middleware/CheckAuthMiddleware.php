<?php

namespace app\Middleware;

use app\Middleware\Kernel\BeforeMiddlewareInterface;

use app\Core\Session;
use modules\User\UserService;

class CheckAuthMiddleware implements BeforeMiddlewareInterface {

    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function handle(callable $next): void {
        if ($this->isStaticAssetRequest()) {
            $next();
            return;
        }

        $user_data = Session::get('user_data');

        // Verificar si el usuario tiene sesión válida
        if (empty($user_data['id']) || $this->userService->isValidAccessById($user_data['id']) == false || empty($_SESSION['token'])) {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

            if ($isAjax) {
                http_response_code(401);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error' => 'Sesión expirada', 'session_on' => false]);
            } else {
                $loginUrl = defined('URL_PATH') ? URL_PATH . 'Login' : '/Login';
                header('Location: ' . $loginUrl);
            }
            exit;
        }

        // Si pasa la validación, continúa
        $next();
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