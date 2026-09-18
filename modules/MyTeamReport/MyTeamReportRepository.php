<?php

namespace modules\MyTeamReport;

use app\utilities\Repository;

class MyTeamReportRepository extends Repository
{
    // private const DATA_TABLE_PROCEDURE = 'sp_list_my_team_report';

    public function __construct()
    {
        $this->setModel(new MyTeamReportModel());
    }

    public function searchReportDataTable(object $dto): mixed
    {
        // El filtro viene en $dto->filter como JSON (por las transformaciones del Service/Validator)
        $filter = [];
        if (!empty($dto->filter)) {
            $filter = is_string($dto->filter) ? json_decode($dto->filter, true) : (array) $dto->filter;
        }

        $start = $filter['start_date'] ?? $filter['startDate'] ?? $filter['from'] ?? '';
        $end = $filter['end_date'] ?? $filter['endDate'] ?? $filter['to'] ?? '';

        $start = '';
        $end = '';

        if (!empty($start)) {
            $ts = strtotime($start);
            $start = ($ts !== false) ? date('Y-m-d', $ts) : '';
        }

        if (!empty($end)) {
            $ts = strtotime($end);
            $end = ($ts !== false) ? date('Y-m-d', $ts) : '';
        }

        $group = $filter['group_id'] ?? $filter['group'] ?? $filter['hotel_code'] ?? $filter['hotel'] ?? '';
        $employee = $filter['employee_number'] ?? $filter['employee'] ?? $filter['num_colaborador'] ?? '';

        $composed = sprintf('%s|%s|%s|%s', $start, $end, $group, $employee);

        $result = $this->entityModel->executeBasedProcedure(
            'sp_get_employees',
            ['getByDateAndManagerAsJsonInfo', $composed],
            false
        );

        // Si el procedimiento devuelve una fila con la columna RESPONSE
        if (is_array($result) && isset($result['RESPONSE'])) {
            return $result['RESPONSE'] ?? '';
        }

        // Si devuelve un conjunto de filas (array indexado), retornamos el JSON
        if (is_array($result)) {
            $isList = array_keys($result) === range(0, count($result) - 1);
            if ($isList) {
                return json_encode($result, JSON_UNESCAPED_UNICODE);
            }

            // Es un array asociativo con una sola fila sin RESPONSE: lo normalizamos a lista
            return json_encode([$result], JSON_UNESCAPED_UNICODE);
        }

        return '';
    }
}