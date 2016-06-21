<?php

namespace Spatie\Menu\Helpers;

class Url
{
    public static function stripTrailingSlashes(string $url): string
    {
        return rtrim($url, '/');
    }

    public static function parts(string $url): array
    {
        $url = parse_url(Url::stripTrailingSlashes($url, '/'));

        return [
            'host' => $url['host'] ?? '',
            'path' => $url['path'] ?? '',
        ];
    }
}
