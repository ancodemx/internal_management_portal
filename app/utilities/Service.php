<?php

namespace app\utilities;

abstract class Service
{
    protected $repository;
    protected $validator;

    protected $model;

    // Definimos propiedades donde se encuentran los métodos de validación
    // Estas deben estar definidas en la clase padre y en las clases hijas correspondientes
    // El objetivo es poder reutilizar las validaciones en diferentes servicios
    protected $searchDataTableDto;
    protected $createDto;
    protected $updateDto;
    protected $deleteDto;
    protected $searchByIdDto;

    // El constructor lo implementa cada hijo para asignar $repository y $validator


    /**
     * Guarda.
     *
     * @param array $post
     * @return array
     */
    public function create( array $postData ) : array
    {
        $validationResult = $this->validator->validateCreate($postData, $this->createDto);

        $response = $this->repository->create($validationResult, $this->model);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Error al guardar el registro.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro guardado correctamente.", 'response' => $response];
    }


    public function update( array $postData ) : array
    {
        $validationResult = $this->validator->validateUpdate($postData, $this->updateDto);

        $response = $this->repository->update($validationResult, $this->model);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Error al actualizar el registro.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro actualizado correctamente.", 'response' => $response];
    }


    public function delete( array $postData ) : array
    {
        $validationResult = $this->validator->validateDelete($postData, $this->deleteDto);

        $response = $this->repository->delete($validationResult);

        if ( $response['is_error'] || empty($response) )
            return ['is_error' => true, 'message' => "Error al eliminar el registro.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro eliminado correctamente.", 'response' => $response['is_deleted']];
    }


    /**
     * Obtiene un registro por su ID y devuelve información en formato JSON.
     *
     * @param int $id   ID del registro.
     * @return array
     * @throws DataStatusException
     */
    public function getByIdAsArrayInfo(int $id) : array
    {
        $validationResult = $this->validator->validateId($id, $this->searchByIdDto);

        $response = $this->repository->getByIdAsJsonInfo($validationResult->id);
        $response = \app\Utils\TransformUtils::recursiveJsonDecode($response);

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro no encontrado.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro encontrado.", 'response' => $response];
    }


    /**
     * Busca datos en una tabla utilizando un procedimiento almacenado.
     *
     * @param array $data            Datos a buscar.
     * @param string $procedureName  Nombre del procedimiento almacenado.
     * @return array
     */
    /* public function searchDataTable(array $data, string $procedureName) : array
    {
        $validationResult = $this->validator::validateDataTable($data, $this->searchDataTableDto);

        $response = $this->repository->searchDataTable($validationResult, $procedureName);
        $response = \app\Utils\TransformUtils::jsonToArray($response ?? '');

        if (empty($response))
            return ['is_error' => true, 'message' => "No se encontraron resultados.", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Resultados encontrados.", 'response' => $response];
    } */


    /**
     * Obtiene un catálogo de entidades.
     *
     * @return array
     */
    public function getCatalogue() : array
    {
        $response = $this->repository->getCatalogue();

        if ( empty($response) )
            return ['is_error' => true, 'message' => "Registro(s) no encontrado(s).", 'response' => []];
        else
            return ['is_error' => false, 'message' => "Registro(s) encontrado(s).", 'response' => $response];
    }
    
}