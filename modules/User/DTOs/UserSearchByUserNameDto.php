<?php

namespace modules\User\DTOs;

class UserSearchByUserNameDto
{
    /**
     * @Name("username")
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $username;


}