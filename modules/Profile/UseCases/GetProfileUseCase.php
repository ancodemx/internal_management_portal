<?php

namespace modules\Profile\UseCases;

use modules\Profile\ProfileService;

use app\config\Maps\PermissionMap;

use app\Utils\AppResponse;

use app\Exceptions\ResponseException;

use Throwable;

class GetProfileUseCase
{
    private ProfileService $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }


    public function execute(int $profile_id ) : array
    {
        try {

            $response  = $this->profileService->getByIdAsArrayInfo($profile_id);

            // Igualamos el response para manejar mejor la data pura extraida de la bd
            $profile_data = $response['response'] ?? [];

            // Aplicar transformación para indices correctos
            $profile_data = $this->transformProfileData($profile_data);

            if ($response['is_error'])
                throw new ResponseException($response['message'], 0, ["alert_type" => "error"], 400, false);

            return AppResponse::success(
                "Registro obtenido exitosamente.",
                ["alert_type" => "success"],
                $profile_data,
                201,
                0
            );


        } catch (\Throwable $e) {
            // Limpia recursos si es necesario
            throw $e; // <-- vuelve a lanzar la excepción
        }
    }


    function transformProfileData(array $profile): array
    {
        // Invertimos MAP para buscar por valor
        $map = PermissionMap::MAP;
        $mapFlipped = array_flip($map);

        // Transformar json_items
        $newItems = [];
        foreach ($profile['json_items'] ?? [] as $item) {
            if (isset($mapFlipped[$item])) {
                $newItems[$mapFlipped[$item]] = $item;
            }
        }

        // Transformar json_permissions
        $newPerms = [];
        foreach ($profile['json_permissions'] ?? [] as $perm) {
            if (isset($mapFlipped[$perm])) {
                $newPerms[$mapFlipped[$perm]] = $perm;
            } else {
                $newPerms[$perm] = $perm; // Si no está en MAP, lo deja igual
            }
        }

        $profile['json_items'] = $newItems;
        $profile['json_permissions'] = $newPerms;

        return $profile;
    }
}
