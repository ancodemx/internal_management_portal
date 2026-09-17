<?php

namespace modules\User\UseCases;

use app\Core\Transaction;

// use modules\User\Factories\UserFactory;

use modules\User\UserService;

use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class DeleteUserUseCase
{
    private UserService $userService;
    private Transaction $transaction;

    public function __construct() {
        $this->userService = new UserService();
        $this->transaction = new Transaction();
    }


    public function execute(array $userPostData ) : array
    {
        $this->transaction->startTransaction();

        try {

            $response = $this->userService->delete($userPostData);

            if (!$response)
                throw new ResponseException("Error al eliminar el usuario.", 0, ["alert_type" => "error"], 400, false);

            $this->transaction->commit();
            $this->transaction->closeConnection();

            return AppResponse::success(
                "Usuario eliminado exitosamente.",
                ["alert_type" => "success"],
                [],
                201,
                0
            );

        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            $this->transaction->rollback();
            $this->transaction->closeConnection();
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }
}
