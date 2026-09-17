<?php

namespace modules\Profile;

use modules\Profile\ProfileModel;

use app\utilities\Repository;

class ProfileRepository extends Repository
{
    private $profileModel;

    public function __construct()
    {
        // $this->profileModel = new ProfileModel();
        $this->setModel(new ProfileModel());
    }


    public function existsByProfileName( string $username ) : bool
    {
        return $this->entityModel->get(
            ['existByProfileName', $username],
            true
        )['RESPONSE'];
    }


    public function delete(object $dto) : array
    {
        return $this->entityModel->executeBasedProcedure(
            'sp_update_profiles',
            ['delete', $dto->id, $dto->userActionId],
            true
        );
    }

}