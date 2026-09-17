<?php

namespace modules\User\DTOs;

class UserSearchByEmailDto
{
    /**
     * @Name("email")
     * @Required
     * @Type("string")
     * @Email
     * @NoSpecialCharacters
     */
    public $email;

}