<?php

namespace modules\Profile;

use modules\Profile\ProfileRepository;
use modules\Profile\ProfileValidator;

use app\Utils\TransformUtils;

class ProfileService extends \app\utilities\Service
{

    protected $getByProfileNameDtoClass;

    public function __construct()
    {
        $this->repository = new ProfileRepository();
        $this->validator = new ProfileValidator();

        $this->model = ProfileModel::class;

        $this->getByProfileNameDtoClass = \modules\Profile\DTOs\ProfileSearchByProfileNameDto::class;

        $this->createDto = \modules\Profile\DTOs\ProfileCreateDto::class;
        $this->updateDto = \modules\Profile\DTOs\ProfileUpdateDto::class;
        $this->deleteDto = \app\utilities\global_dto\DeleteDto::class;
        $this->searchDataTableDto = \app\utilities\global_dto\SearchDataTableDto::class;
        $this->searchByIdDto = \app\utilities\global_dto\SearchByIdDto::class;
    }


    public function existsByProfileName(string $profileName) : bool
    {
        $validationResult = $this->validator->validateProfileName($profileName, $this->getByProfileNameDtoClass);

        return $this->repository->existsByProfileName($validationResult->profileName);
    }

    
    /**
     * Busca datos de usuario para DataTable.
     *
     * @param array $data   Parámetros de DataTable.
     * @return array
     */
    public function searchDataTable(array $data) : array
    {   
        $validationResult = $this->validator->validateDataTable($data, $this->searchDataTableDto);

        $response = $this->repository->searchDataTable($validationResult, 'sp_list_profiles');
        
        $response = TransformUtils::jsonToArray($response);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "No se encontraron resultados."];
        else
            return ['is_error' => false, 'message' => "Resultados encontrados.", 'response' => $response];
    }

}