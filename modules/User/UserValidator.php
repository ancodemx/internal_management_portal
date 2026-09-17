<?php

namespace modules\User;

use app\utilities\Validator;
use app\Core\Handler;

use app\Exceptions\ResponseException;

// use modules\User\DTOs\UserGetInfoByUserNameDto;
// use modules\User\DTOs\UserSearchDataTableDto;
// use modules\User\DTOs\UserCreateDto;

class UserValidator extends Validator{

    /**
     * Valida el UserName de un Usuario.
     * 
     * @param string $username   Nombre de usuario a validar.
     * @return entityDto
     * @throws DataStatusException
     */
    public function validateUserName( string $username, string $dto ) : object
    {
        // $inputEntity = new Handler(UserGetInfoByUserNameDto::class);
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_single_value('username', $username);
        
        if (is_array($entityDto) && !empty($entityDto['errors']))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }


    public function validateEmail( string $email, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_single_value('email', $email);

        if (is_array($entityDto) && !empty($entityDto['errors']))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }


    /* public function validateUserCreate( array $post ) : object
    {
        $inputEntity = new Handler(UserCreateDto::class);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    } */


    /**
     * Valida los datos para la busqueda para la data table.
     * 
     * @param array
     * @return object
     * @throws DataStatusException Si los datos no son válidos.
     * @inheritdoc Se sobreescribe el metodo de la clase padre ya que se nececita un dto especifico (polimorfismo)
     */
    /* public function validateDataTable( array $post, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    } */

}