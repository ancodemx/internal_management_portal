<?php

namespace app\utilities;

use app\Core\Handler;

use app\Exceptions\ResponseException;

/**
 * Clase abstracta Validator.
 * Esta clase se encarga de validar los datos de entrada.
 */
abstract class Validator
{

    /**
     * Verifica si un registro existe por su ID.
     * @param int $id
     * @return object
     * @throws DataStatusException Si el registro no se encuentra.
     */
    public function validateId( int $id, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_single_value('id', $id);

        if (is_array($entityDto) && !empty($entityDto['errors']))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);
        
        return $entityDto;
    }


    public function validateCreate( array $post, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }


    public function validateUpdate( array $post, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }


    public function validateDelete( array $post, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }


    /**
     * Valida los datos para la busqueda para la data table.
     * 
     * @param array
     * @return object
     * @throws DataStatusException Si los datos no son válidos.
     * @inheritdoc Se sobreescribe el metodo de la clase padre ya que se nececita un dto especifico (polimorfismo)
     */
    public function validateDataTable( array $post, string $dto ) : object
    {
        $inputEntity = new Handler($dto);

        $entityDto = $inputEntity->handle_mixed($post);

        if (is_array($entityDto) && !empty($entityDto))
            throw new ResponseException($entityDto['errors'][0]['message'], 0, ['alert_type' => 'warning'], 203);

        return $entityDto;
    }

}