<?php

namespace modules\User\DTOs;

class UserGetInfoByUserNameDto
{
    /**
     * @Name("username")
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $username;


}