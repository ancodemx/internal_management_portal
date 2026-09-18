<?php

namespace modules\MyTeamReport\UseCases;

use app\Utils\AppResponse;
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

        // Retornamos directamente el array de registros para que el cliente cargue el DataTable en modo cliente-side
        return AppResponse::success(
            'Registros obtenidos correctamente.',
            ['alert_type' => 'success'],
            $result['response'] ?? []
        );
    }
}