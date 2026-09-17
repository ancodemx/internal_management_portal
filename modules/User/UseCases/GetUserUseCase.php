<?php

namespace modules\User\UseCases;

use modules\User\UserService;

use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class GetUserUseCase
{
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }


    public function execute(int $user_id ) : array
    {
        try {

            $response  = $this->userService->getByIdAsArrayInfo($user_id);

            // Igualamos el response para manejar mejor la data pura extraida de la bd
            $user_data = $response['response'] ?? [];

            $user_data['json_categories'] = json_encode($user_data['json_categories'] ?? []);
            

            if ($response['is_error'])
                throw new ResponseException($response['message'], 0, ["alert_type" => "error"], 400, false);

            return AppResponse::success(
                "Registro obtenido exitosamente.",
                ["alert_type" => "success"],
                $user_data,
                200,
                0
            );

        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }
}
