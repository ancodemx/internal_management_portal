<?php

namespace app\utilities\Factory;

class DataTableResponseFactory
{

    public static function make(array $data, array $overrides = []): array
    {
        $base = [
            'total_data' => $data['total_data'] ?? 0,
            'total_filter' => $data['total_filter'] ?? 0,
            'data_list' => $data['data_list'] ?? [],
        ];
        
        return array_merge($base, $overrides);
    }
}