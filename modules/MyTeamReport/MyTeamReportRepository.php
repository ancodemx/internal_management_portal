<?php

namespace modules\MyTeamReport;

use app\utilities\Repository;

class MyTeamReportRepository extends Repository
{
    private const DATA_TABLE_PROCEDURE = 'sp_list_my_team_report';

    public function __construct()
    {
        $this->setModel(new MyTeamReportModel());
    }

    public function searchReportDataTable(object $dto): mixed
    {
        return parent::searchDataTable($dto, self::DATA_TABLE_PROCEDURE);
    }
}