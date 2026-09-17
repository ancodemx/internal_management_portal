<?php

namespace modules\User;

use modules\User\UserRepository;
use modules\User\UserValidator;

// use modules\User\DTOs\UserGetInfoByUserNameDto;
// use modules\User\DTOs\UserSearchDataTableDto;
// use modules\User\DTOs\UserCreateDto;

use app\Utils\TransformUtils;

class UserService extends \app\utilities\Service
{
    // private $userRepository;
    protected $getInfoByUsernameDtoClass;
    protected $getByUserNameDtoClass;
    protected $getByEmailDtoClass;
    // protected $createDto;
    // protected $searchDataTableDto;
    // protected $searchByIdDto;

    public function __construct()
    {
        $this->repository = new UserRepository();
        // $this->validator = UserValidator::class;
        $this->validator = new UserValidator();

        // IMPORTANTE
        // Asignar el modelo, esta se encuentra como parametro en Service.php
        // Esto permite que el servicio conozca el modelo que está utilizando para hacerlo mas dinámico y reutilizar código
        $this->model = UserModel::class;

        // Asignar los DTOs utilizados en las validaciones
        $this->getInfoByUsernameDtoClass = \modules\User\DTOs\UserGetInfoByUserNameDto::class;
        $this->getByUserNameDtoClass = \modules\User\DTOs\UserSearchByUserNameDto::class;
        $this->getByEmailDtoClass = \modules\User\DTOs\UserSearchByEmailDto::class;

        // Estas propiedades estan definidas en Service ya que son las utilizadas en las validaciones y poder reutilizar código
        $this->createDto = \modules\User\DTOs\UserCreateDto::class;
        $this->updateDto = \modules\User\DTOs\UserUpdateDto::class;
        $this->deleteDto = \app\utilities\global_dto\DeleteDto::class;
        $this->searchDataTableDto = \app\utilities\global_dto\SearchDataTableDto::class;
        $this->searchByIdDto = \app\utilities\global_dto\SearchByIdDto::class;
    }


    /**
     * Guarda.
     *
     * @param array $post
     * @return array
     */
    /* public function create( array $userPostData ) : array
    {
        $validationResult = $this->validator::validateUserCreate($userPostData);

        $response = $this->repository->create($validationResult, UserModel::class);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Error al guardar el registro."];
        else
            return ['is_error' => false, 'message' => "Registro guardado correctamente.", 'response' => $response];
    } */

    /**
     * Obtiene un usuario por su nombre de usuario.
     *
     * @param string $username   Nombre de usuario del publicador.
     * @return array
     * @throws DataStatusException
     */
	public function getByUserName(string $username) : array
    {
        $validationResult = $this->validator->validateUserName($username, $this->getInfoByUsernameDtoClass);

        $response = $this->repository->getByUserName($validationResult->username);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado."];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    }


    public function isValidAccessById(int $id) : bool
    {
        $validationResult = $this->validator->validateId($id, $this->searchByIdDto);

        return $this->repository->isValidAccessById($validationResult->id);
    }


    public function existsByUserName(string $username) : bool
    {
        $validationResult = $this->validator->validateUserName($username, $this->getByUserNameDtoClass);

        return $this->repository->existsByUserName($validationResult->username);
    }

    public function existsByEmail(string $email) : bool
    {
        $validationResult = $this->validator->validateEmail($email, $this->getByEmailDtoClass);

        return $this->repository->existsByEmail($validationResult->email);
    }


    /**
     * Obtiene un usuario por su ID y devuelve información en formato JSON.
     *
     * @param int $id   ID del usuario.
     * @return array
     * @throws DataStatusException
     */
    /* public function getByIdAsArrayInfo(int $id) : array
    {
        $validationResult = $this->validator::validateId($id);

        $response = $this->repository->getByIdAsJsonInfo($validationResult->id);
        // $response = json_decode($response, true);
        $response = TransformUtils::jsonToArray($response);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado."];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    } */


    /**
     * Busca datos de usuario para DataTable.
     *
     * @param array $data   Parámetros de DataTable.
     * @return array
     */
    public function searchDataTable(array $data) : array
    {
        $validationResult = $this->validator->validateDataTable($data, $this->searchDataTableDto);

        $response = $this->repository->searchDataTable($validationResult, 'sp_list_users');
        
        $response = TransformUtils::jsonToArray($response);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "No se encontraron resultados."];
        else
            return ['is_error' => false, 'message' => "Resultados encontrados.", 'response' => $response];
    }

}

