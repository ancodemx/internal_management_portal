<?php

namespace modules\Profile\UseCases;

use app\Core\Transaction;

use modules\Profile\Factories\ProfileFactory;
use modules\Profile\ProfileService;

use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class CreateProfileUseCase
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

			$profile_post_data = ProfileFactory::make($userPostData);

            // Validar que profile_name no este repetido
            if ($this->profileService->existsByProfileName($profile_post_data['profile_name']))
                throw new ResponseException("El nombre de perfil ya está en uso.", 0, ["alert_type" => "warning"], 203, false);

            $response  = $this->profileService->create($profile_post_data);

            if ($response['is_error'])
                throw new ResponseException($response['message'], 0, ["alert_type" => "error"], 400, false);

            $this->transaction->commit();
            $this->transaction->closeConnection();

            return AppResponse::success(
                "Perfil creado exitosamente.",
                ["alert_type" => "success"],
                $response['response'],
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
