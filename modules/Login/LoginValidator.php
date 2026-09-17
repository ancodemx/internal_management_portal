<?php

namespace modules\Login;

use app\utilities\Validator;
use app\Core\Handler;

use app\Exceptions\ResponseException;

use modules\Login\DTOs\UserAuthDto;

class LoginValidator extends Validator{

    /**
     * Valida el UserName de un Usuario.
     * 
     * @param string $username   Nombre de usuario a validar.
     * @return entityDto
     * @throws DataStatusException
     */
    public static function validateLogin( array $loginData  ) : object
    {
        $inputEntity = new Handler(UserAuthDto::class, 'login');
        $entityDto = $inputEntity->handle_mixed($loginData);

        if (is_array($entityDto) && !empty($entityDto['errors']))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);
    

        return $entityDto;
    }

}