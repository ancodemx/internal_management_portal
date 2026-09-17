<?php

namespace modules\Profile\Factories;

class DataTableFactory
{

    public static function make(array $post_data, array $overrides = []): array
    {
        $base = [
            'ban' => $post_data['ban'] ?? null,
            'draw' => $post_data['draw'] ?? 0,
            'row' => $post_data['start'] ?? 0,
            'rows' => $post_data['length'] ?? 15,
            'search' => $post_data['search']['value'] ?? '',
            'filter' => $post_data['filter'] ?? [],
        ];
        
        return array_merge($base, $overrides);
    }
}