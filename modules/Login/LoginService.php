<?php

namespace modules\Login;

use modules\Login\LoginRepository;
use modules\Login\LoginValidator;

class LoginService extends \app\utilities\Service
{
    private LoginRepository $loginRepository;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
        $this->validator = new LoginValidator();

        $this->searchByIdDto = \app\utilities\global_dto\SearchByIdDto::class;
    }


    /**
     * Obtiene los elementos del menú por el ID del perfil padre.
     *
     * @param string $id   ID del perfil padre.
     * @return array
     * @throws DataStatusException
     */
	public function findItemsMenuByProfileParent(int $id) : array
    {
        // $validationResult = LoginValidator::validateId($id, $this->searchByIdDto);
        $validationResult = $this->validator->validateId($id, $this->searchByIdDto);

        $response = $this->loginRepository->findItemsMenuByProfileParent($validationResult->id);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    }


    /**
     * Obtiene los elementos del menú por el ID del perfil hijo.
     *
     * @param string $id   ID del perfil hijo.
     * @return array
     * @throws DataStatusException
     */
    public function findItemsMenuByProfileChild(int $id) : array
    {
        // $validationResult = LoginValidator::validateId($id, $this->searchByIdDto);
        $validationResult = $this->validator->validateId($id, $this->searchByIdDto);

        $response = $this->loginRepository->findItemsMenuByProfileChild($validationResult->id);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado."];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    }


    /**
     * Obtiene los permisos por el ID del perfil.
     *
     * @param string $id   ID del perfil.
     * @return array
     * @throws DataStatusException
     */
    public function findByPermissionsByProfile(int $id) : array
    {
        // $validationResult = LoginValidator::validateId($id, $this->searchByIdDto);
        $validationResult = $this->validator->validateId($id, $this->searchByIdDto);

        $response = $this->loginRepository->findByPermissionsByProfile($validationResult->id);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado."];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    }


}