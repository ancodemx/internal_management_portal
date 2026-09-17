<?php

namespace modules\Profile\DTOs;

class ProfileUpdateDto
{
    /**
     * @Name("id")
     * @Trim
     * @Required
     * @Type("integer")
     * @NoSpecialCharacters
     */
    public $id;

    /**
     * @Name("profile_name")
     * @Trim
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $profileName;

    /**
     * @Name("description_name")
     * @Trim
     * @Required
     * @Type("string")
     * @NoSpecialCharacters
     */
    public $descriptionName;

    /**
     * @Name("json_items")
     * @Required
     * @ArrayToJson
     */
    public $jsonItems;

    /**
     * @Name("json_permissions")
     * @Required
     * @ArrayToJson
     */
    public $jsonPermissions;

    /**
     * @Name("user_action_id")
     * @Trim
     * @Required
     * @Type("integer")
     * @NoSpecialCharacters
     */
    public $userActionId;

}