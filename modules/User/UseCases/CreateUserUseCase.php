<?php

namespace modules\User\UseCases;

use app\Core\Transaction;

use modules\User\Factories\UserFactory;

use modules\User\UserService;

use app\Utils\PasswordUtils;
use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class CreateUserUseCase
{
    private UserService $userService;
    private Transaction $transaction;

    public function __construct() {
        $this->userService = new UserService();
        $this->transaction = new Transaction();
    }


    public function execute(array $userPostData, bool $use_transaction = true, bool $close_db_connection = true) : array
    {
        if ($use_transaction) $this->transaction->startTransaction();

        try {

            // Crea el molde del usuario
			$user_post_data = UserFactory::make($userPostData);

            // Validar que el email no este repetido.
            if ($this->userService->existsByEmail($user_post_data['email']))
                throw new ResponseException("El email ya está en uso.", 0, ["alert_type" => "warning"], 409, false);

            // Validar que el usuario no este repetido.
            if ($this->userService->existsByUserName($user_post_data['username']))
                throw new ResponseException("El nombre de usuario ya está en uso.", 0, ["alert_type" => "warning"], 409, false);

            // Validar que las contraseñas coincidan.
            if ($user_post_data['password'] !== $user_post_data['confirm_password'])
                throw new ResponseException("Las contraseñas no coinciden.", 0, ["alert_type" => "warning"], 409, false);

            // Minimo de 8 caracteres.
            if (!PasswordUtils::validatePasswordLength($user_post_data['password']))
                throw new ResponseException("La contraseña debe tener al menos 8 caracteres.", 0, ["alert_type" => "warning"], 409, false);

            // Al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.
            if (!PasswordUtils::validatePasswordStrength($user_post_data['password']))
                throw new ResponseException("La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.", 0, ["alert_type" => "error"], 409, false);

            // Hashear la contraseña
            $user_post_data['password'] = PasswordUtils::hashPassword($user_post_data['password']);

            $response  = $this->userService->create($user_post_data);

            if ($response['is_error'])
                throw new ResponseException($response['message'], 0, ["alert_type" => "error"], 400, false);

            if ($use_transaction) {
                $this->transaction->commit();
                if ($close_db_connection)
                    $this->transaction->closeConnection();
            }

            return AppResponse::success(
                "Usuario creado exitosamente.",
                ["alert_type" => "success"],
                $response['response'],
                201,
                0,
            );

        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            if ($use_transaction) {
                $this->transaction->rollback();
                if ($close_db_connection)
                    $this->transaction->closeConnection();
            }
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }
}
