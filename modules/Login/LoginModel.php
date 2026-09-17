<?php

namespace modules\Login;

use app\Core\EntityModel;

class LoginModel extends EntityModel
{
    protected $bd = DB_NAME;
    protected $table = '';

    private string $ban = '';

    private ?string $username = NULL;
    private ?string $password = NULL;

    
    public function getBan()
    {
        return $this->ban;
    }

    public function setBan($ban)
    {
        $this->ban = $ban;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

}

?>