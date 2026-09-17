<?php

namespace modules\Profile\UseCases;

use modules\Profile\ProfileService;

use app\Utils\AppResponse;

class CatalogueUseCase
{
    private ProfileService $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }

    public function execute(array $data) : array
    {
        try {

            $response  = $this->profileService->getCatalogue();

            // Del catalogo excluir SYSADMIN
            $response['response'] = array_filter($response['response'], fn($item) => $item['description'] !== 'SYSADMIN');

            return AppResponse::success(
                $response['message'],
                ["alert_type" => "success"],
                $response['response'],
                200,
                0
            );

        } catch (\Throwable $e) {

            throw $e; // <-- vuelve a lanzar la excepción
        }
    }

}