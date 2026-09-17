<?php

namespace modules\Profile;

use app\utilities\Validator;
use app\Core\Handler;

use app\Exceptions\ResponseException;


class ProfileValidator extends Validator{

    /**
     * Valida el ProfileName de un Usuario.
     * 
     * @param string $profileName   Nombre de perfil a validar.
     * @return entityDto
     * @throws DataStatusException
     */
    public static function validateProfileName( string $profileName, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_single_value('profile_name', $profileName);
        
        if (is_array($entityDto) && !empty($entityDto['errors']))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }

}