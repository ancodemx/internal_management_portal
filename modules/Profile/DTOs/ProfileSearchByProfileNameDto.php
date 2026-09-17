<?php

namespace modules\Profile\DTOs;

class ProfileSearchByProfileNameDto
{
    /**
     * @Name("profile_name")
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $profileName;


}