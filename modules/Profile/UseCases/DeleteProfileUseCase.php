<?php

namespace modules\Profile\UseCases;

use app\Core\Transaction;

use modules\Profile\ProfileService;

use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class DeleteProfileUseCase
{
    private ProfileService $profileService;
    private Transaction $transaction;

    public function __construct() {
        $this->profileService = new ProfileService();
        $this->transaction = new Transaction();
    }


    public function execute(array $userPostData ) : array
    {
        $this->transaction->startTransaction();

        try {

            $response = $this->profileService->delete($userPostData);

            if (!$response)
                throw new ResponseException("Error al eliminar el perfil.", 0, ["alert_type" => "error"], 400, false);

            $this->transaction->commit();
            $this->transaction->closeConnection();

            return AppResponse::success(
                "Perfil eliminado exitosamente.",
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
