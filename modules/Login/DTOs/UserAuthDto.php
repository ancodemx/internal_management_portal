<?php

namespace modules\Login\DTOs;

class UserAuthDto
{
    /**
    * @Name("username")
    * @Required
    * @Trim
    * @Type("string")
    * @NoSpecialCharacters
    */
    public $username;

    /**
    * @Name("password")
    * @Required
    * @Trim
    * @Type("string")
    */
    public $password;


}

?>