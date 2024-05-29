<?php

namespace App\Helpers;

class Helpers
{
    public static function getQueryParams($settings, $key): array
    {
        $parse = parse_url($settings[$key]);
        $query = $parse['query'] ?? '';
        $query = trim($query, '?');
        $query = explode('&', $query);
        $result = [];
        foreach ($query as $item) {
            $explode = explode('=', $item);
            $result[] = $explode;
        }
        return $result;
    }
}
