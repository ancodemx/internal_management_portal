<?php

namespace modules\MyTeamReport\UseCases;

use app\Helpers\DataTableRowBuilder;
use app\Utils\AppResponse;
use app\utilities\Factory\DataTableResponseFactory;
use modules\MyTeamReport\Factories\MyTeamReportDataTableFactory;
use modules\MyTeamReport\MyTeamReportService;

class GetMyTeamReportDataTableUseCase
{
    private MyTeamReportService $myTeamReportService;

    public function __construct()
    {
        $this->myTeamReportService = new MyTeamReportService();
    }

    public function execute(array $postData): array
    {
        $dataTableParams = MyTeamReportDataTableFactory::make($postData);
        $result = $this->myTeamReportService->searchDataTable($dataTableParams);
        $response = DataTableResponseFactory::make($result['response'] ?? []);

        $dataTable = DataTableRowBuilder::buildRows(
            $dataTableParams['draw'],
            $response,
            static function (array $row): array {
                return [
                    $row['employee_number'] ?? $row['num_colaborador'] ?? $row['numero_colaborador'] ?? '',
                    $row['full_name'] ?? $row['nombre_completo'] ?? '',
                    $row['department'] ?? $row['departamento'] ?? '',
                    $row['position'] ?? $row['cargo'] ?? '',
                ];
            }
        );

        return AppResponse::success(
            'DataTable obtenida correctamente.',
            ['alert_type' => 'success'],
            $dataTable
        );
    }
}