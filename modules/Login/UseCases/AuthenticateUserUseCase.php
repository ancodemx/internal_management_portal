<?php

namespace modules\Login\UseCases;

use modules\User\UserService;
use modules\Login\LoginValidator;

use app\Utils\TransformUtils;
use app\Utils\PasswordUtils;
use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

/**
 * Caso de uso: Guardar un nuevo publicador.
 * Orquesta la validación, guardado y relaciones necesarias.
 */
class AuthenticateUserUseCase
{
    private UserService $userService;
    // private Transaction $transaction;

    public function __construct() {
        $this->userService = new UserService();
        // $this->transaction = new Transaction();
    }

    /**
     * Ejecuta el caso de uso: guardar un publicador.
     *
     * @param array $loginData  Datos del publicador
     * @return array Respuesta estandarizada
     */
    public function execute(array $loginData ) : array
    {
        // $this->transaction->startTransaction();

        try {

            // Validar los datos de entrada (username y password) y el resultado lo igualamos a $loginData nuevamente
            $validationResult = LoginValidator::validateLogin($loginData);
            $loginData = TransformUtils::objectToArray($validationResult);  

            // Validar que el usuario exista
            $auth_data  = $this->userService->getByUserName($loginData['username'] ?? '');
            if ($auth_data['is_error'])
                throw new ResponseException("Nombre de usuario incorrecto.", 0, ["alert_type" => "warning"], 203, false);

            // Validar su status
            if ($auth_data['response']['status'] == 0)
                throw new ResponseException("No puede iniciar sesión.", 0, ["alert_type" => "danger"], 203, false);
            
            // Validar que la contraseña sea correcta
            if (!PasswordUtils::verifyPassword($loginData['password'], $auth_data['response']["password"])) {
                session_unset();
                session_destroy();
                throw new ResponseException("Contraseña incorrecta.", 0, ["alert_type" => "danger"], 203, false);
            }

            // Si todo es correcto, obtenemos los datos del usuario
            $user_data = $this->userService->getByIdAsArrayInfo($auth_data['response']['id']);
            // $this->transaction->commit();
            // $this->transaction->closeConnection();

            
            return AppResponse::success(
                "Acceso autorizado.",
                ["alert_type" => "success"],
                $user_data['response'],
                201,
                0
            );

        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            // $this->transaction->rollback();
            // $this->transaction->closeConnection();
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }
}
