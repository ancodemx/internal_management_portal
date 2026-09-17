<?php

namespace modules\MyTeamReport\DTOs;

class MyTeamReportDataTableDto
{
    /** @Name("draw") @Type("integer") */
    public $draw;

    /** @Name("row") @Type("integer") */
    public $row;

    /** @Name("rows") @Type("integer") */
    public $rows;

    /** @Name("search") @Type("string") */
    public $search;

    /** @Name("filter") @Required @Type("string") @ArrayToJson @NoSpecialCharacters */
    public $filter;
}