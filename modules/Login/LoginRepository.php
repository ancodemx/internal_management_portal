<?php

namespace modules\Login;

interface LoginRepositoryInterface
{

}

class LoginRepository implements LoginRepositoryInterface 
{
    private LoginModel $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }


    public function findItemsMenuByProfileParent( $profile )
    {
        return $this->loginModel->executeBasedProcedure(
            'sp_get_items_menu',
            [1, $profile],
            false
        );
    }


    public function findItemsMenuByProfileChild( $profile )
    {
        return $this->loginModel->executeBasedProcedure(
            'sp_get_items_menu',
            [2, $profile],
            false
        );
    }


    public function findByPermissionsByProfile( $profile )
    {
        return $this->loginModel->executeBasedProcedure(
            'sp_get_permissions',
            [1, $profile],
            false
        );
    }

}