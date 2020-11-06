<?php

namespace Spatie\Menu;

use Spatie\Menu\Helpers\Str;
use Spatie\Url\Url;

class ExactUrlChecker
{
    public static function check(string $url, string $requestUrl, string $rootUrl = '/'): bool
    {
        $url = Url::fromString($url);
        $requestUrl = Url::fromString($requestUrl);

        // If the hosts don't match, this url isn't active.
        if ($url->getHost() !== $requestUrl->getHost()) {
            return false;
        }

        $rootUrl = Str::ensureLeft('/', $rootUrl);

        // All paths used in this method should be terminated by a /
        // otherwise startsWith at the end will be too greedy and
        // also matches items which are on the same level
        $rootUrl = Str::ensureRight('/', $rootUrl);

        $itemPath = Str::ensureRight('/', $url->getPath());

        // If this url doesn't start with the rootUrl, it's inactive.
        if (! Str::startsWith($itemPath, $rootUrl)) {
            return false;
        }

        $matchPath = Str::ensureRight('/', $requestUrl->getPath());

        // For the next comparisons we just need the paths, and we'll remove
        // the rootUrl first.
        $itemPath = Str::removeFromStart($rootUrl, $itemPath);
        $matchPath = Str::removeFromStart($rootUrl, $matchPath);

        // If this url is an exact match for the url we're matching with, it's exact-active.
        if ($matchPath === $itemPath) {
            return true;
        }

        return false;
    }
}
