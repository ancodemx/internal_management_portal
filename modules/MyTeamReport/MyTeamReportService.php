<?php

namespace modules\MyTeamReport;

use app\Utils\TransformUtils;
use app\utilities\Service;

class MyTeamReportService extends Service
{
    public function __construct()
    {
        $this->repository = new MyTeamReportRepository();
        $this->validator = new MyTeamReportValidator();
        $this->searchDataTableDto = \modules\MyTeamReport\DTOs\MyTeamReportDataTableDto::class;
    }

    public function searchDataTable(array $data): array
    {
        $dto = $this->validator->validateDataTable($data, $this->searchDataTableDto);
        $response = TransformUtils::jsonToArray($this->repository->searchReportDataTable($dto));

        return [
            'is_error' => empty($response),
            'message' => empty($response) ? 'No se encontraron resultados.' : 'Resultados encontrados.',
            'response' => $response,
        ];
    }
}