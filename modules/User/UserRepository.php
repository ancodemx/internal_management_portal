<?php

namespace modules\User;

use app\Core\Builder;

// use modules\User\UserModel;

use app\utilities\Repository;

class UserRepository extends Repository
{
    // private $userModel;

    public function __construct()
    {
        // $this->userModel = new UserModel();
        $this->setModel(new UserModel());
    }


    /**
     * Guarda un registro.
     *
     * @param array $post
     * @return array
     */
    /* public function create( object $dto, string $model ) : array
    {
        $builder = new Builder($model);

        $this->entityModel = $builder->build_dto($dto, 'create');

        return $this->entityModel->save();
    } */


    public function getByUserName( string $username ) : mixed
    {
        return $this->entityModel->get(
            ['getByUserName', $username],
            true
        );
    }


    public function isValidAccessById(int $id) : bool
    {
        return $this->entityModel->get(
            ['isValidAccessById', $id],
            true
        )['RESPONSE'];
    }


    public function existsByUserName( string $username ) : bool
    {
        return $this->entityModel->get(
            ['existByUserName', $username],
            true
        )['RESPONSE'];
    }


    public function existsByEmail( string $email ) : bool
    {
        return $this->entityModel->get(
            ['existByEmail', $email],
            true
        )['RESPONSE'];
    }


    public function delete(object $dto) : array
    {
        return $this->entityModel->executeBasedProcedure(
            'sp_update_users',
            ['delete', $dto->id, $dto->userActionId],
            true
        );
    }


    /**
     * Obtene un usuario por su ID.
     * 
     * @param int $id   ID del usuario a verificar.
     * @return bool
     */
    /* public function getByIdAsJsonInfo( int $id )
    {
        return $this->entityModel->get(
            ['getByIdAsJsonInfo', $id],
            true
        )['RESPONSE'] ?? null;
    } */


}