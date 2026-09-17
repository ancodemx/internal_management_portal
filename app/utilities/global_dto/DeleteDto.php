<?php

namespace app\utilities\global_dto;

class DeleteDto
{

    /**
     * @Name("id")
     * @Required
     * @Type("integer")
     * @NoSpecialCharacters
     * @GreaterThan(0)
     */
    public $id;

    /**
     * @Name("user_action_id")
     * @Required
     * @Type("integer")
     */
    public $userActionId;

}