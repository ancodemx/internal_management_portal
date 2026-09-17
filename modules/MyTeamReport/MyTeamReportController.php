<?php

use app\Core\Controller;
use app\Exceptions\ExceptionHandler;
use app\Utils\AppResponse;
use modules\MyTeamReport\UseCases\GetMyTeamReportDataTableUseCase;

class MyTeamReport extends Controller
{
    private GetMyTeamReportDataTableUseCase $getMyTeamReportDataTableUseCase;

    public function __construct()
    {
        $this->getMyTeamReportDataTableUseCase = new GetMyTeamReportDataTableUseCase();
    }

    public function index(): void
    {
        $this->view('my_team_report/MyTeamReport');
    }

    public function data_table_list(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Allow: POST');
                AppResponse::response(true, 'Method Not Allowed', 1, ['alert_type' => 'error'], 405);
                return;
            }

            $response = $this->getMyTeamReportDataTableUseCase->execute($_POST);
            echo json_encode($response['response']);
        } catch (\Throwable $exception) {
            (new ExceptionHandler())->handle($exception);
        }
    }
}