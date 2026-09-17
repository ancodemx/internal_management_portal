<?php

namespace modules\User\DTOs;

class UserCreateDto
{
    /**
     * @Name("id")
     * @Trim
     * @Type("integer")
     * @NoSpecialCharacters
     */
    public $id;

    /**
     * @Name("first_name")
     * @Trim
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $firstName;

    /**
     * @Name("last_name")
     * @Trim
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $lastName;

    /**
     * @Name("middle_name")
     * @Trim
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $middleName;

    /**
     * @Name("email")
     * @Trim
     * @Type("string")
     * @Email
     * @NoSpecialCharacters
     */
    public $email;

    /**
     * @Name("username")
     * @Trim
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $username;

    /**
     * @Name("password")
     * @Trim
     * @Required
     * @Type("string")
     */
    public $password;

    /**
     * @Name("status")
     * @Trim
     * @Required
     * @Type("integer")
     */
    public $profileId;

    /**
     * @Name("json_categories")
     * @Required
     * @ArrayToJson
     */
    public $jsonCategories;

    /**
     * @Name("user_action_id")
     * @Trim
     * @Required
     * @Type("integer")
     * @NoSpecialCharacters
     */
    public $userActionId;

}