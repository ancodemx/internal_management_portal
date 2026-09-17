<?php
namespace app\Helpers;

class DataTableRowBuilder
{
    /**
     * Transforma una lista de datos usando un callback.
     * @param array $data_list
     * @param callable $rowCallback
     * @return array
     */
    public static function buildRows(int $draw, array $data_list, callable $rowCallback): array
    {
        $rows = [];
        foreach ($data_list['data_list'] as $item) {
            $rows[] = $rowCallback($item);
        }
        // return $rows;
        if (empty($data_list)) {
            $json_data = [
                "draw"            => $draw,
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "data"            => NULL
            ];
        } else {
            $json_data = [
                "draw"            => $draw,
                "recordsTotal"    => $data_list['total_data'],
                "recordsFiltered" => $data_list['total_filter'],
                "data"            => $rows
            ];
        }
        return $json_data;
    }
}