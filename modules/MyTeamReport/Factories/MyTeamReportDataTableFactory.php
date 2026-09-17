<?php

namespace modules\MyTeamReport\Factories;

class MyTeamReportDataTableFactory
{
    public static function make(array $postData): array
    {
        return [
            'ban' => $postData['ban'] ?? null,
            'draw' => (int) ($postData['draw'] ?? 0),
            'row' => max(0, (int) ($postData['start'] ?? 0)),
            'rows' => max(1, min(100, (int) ($postData['length'] ?? 15))),
            'search' => trim((string) ($postData['search']['value'] ?? '')),
            'filter' => [
                'start_date' => trim((string) ($postData['start_date'] ?? '')),
                'end_date' => trim((string) ($postData['end_date'] ?? '')),
                'hotel_code' => trim((string) ($postData['hotel_code'] ?? 'ALL')),
            ],
        ];
    }
}