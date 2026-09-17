<?php

namespace app\utilities;

use app\Core\EntityModel;
use app\Core\Builder;

abstract class Repository
{

    /**
     * El modelo utilizado por el repositorio.
     * @var object
     */
    protected $entityModel;

    /**
     * Establece el modelo para el repositorio.
     * @param EntityModel $model
     */
    public function setModel(EntityModel $model) : void
    {
        $this->entityModel = $model;
    }


    /**
     * Crear un registro.
     * @param object $dto
     * @param string $model
     * @return array con la respuesta de la base de datos
     */
    public function create(object $dto, string $model) : array
    {
        $builder = new Builder($model);
        
        $this->entityModel = $builder->build_dto($dto, 'create');

        return $this->entityModel->save();
    }


    /**
     * Actualiza un registro.
     * @param object $dto
     * @param string $model
     * @return array con la respuesta de la base de datos
     */
    public function update(object $dto, string $model) : array
    {
        $builder = new Builder($model);
        
        $this->entityModel = $builder->build_dto($dto, 'update');

        return $this->entityModel->save();
    }


    /* public function delete(object $dto, string $procedureName) : string
    {
        return $this->entityModel->executeBasedProcedure(
            $procedureName,
            ['delete', $dto->id, $dto->userActionId],
            true
        )['RESPONSE'] ?? null;
    } */


    /**
     * Obtiene un registro por su ID.
     * @param int $id
     * @return string|null
     */
    public function getByIdAsJsonInfo( int $id ) : string
    {
        return $this->entityModel->get(
            ['getByIdAsJsonInfo', $id],
            true
        )['RESPONSE'] ?? null;
    }


    /**
     * Obtener la data table de las entidades.
     * @param object $dto
     * @param string $procedureName
     * @return string retorna el json de la data table
     */
    public function searchDataTable(object $dto, string $procedureName) : mixed
    {
        return $this->entityModel->executeBasedProcedure(
            $procedureName,
            ['1', $dto->row, $dto->rows, $dto->search, $dto->filter],
            true
        )['RESPONSE'];
    }


    public function getCatalogue() : array
    {
        return $this->entityModel->get(
            ['getCatalogue', ''],
            false
        );
    }
}
