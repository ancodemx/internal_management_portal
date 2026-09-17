<?php

namespace app\utilities\global_dto;

class SearchByIdDto
{
    /**
     * @Name("id")
     * @Required
     * @Type("integer")
     * @NoSpecialCharacters
     * @GreaterThan(0)
     */
    public $id;

}