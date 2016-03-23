<?php

namespace Spatie\Menu;

use ReflectionFunction;
use ReflectionParameter;

/**
 * @param callable $callable
 *
 * @return string
 */
function first_parameter_type(callable $callable) : string
{
    $reflection = new ReflectionFunction($callable);

    $parameterTypes = array_map(function (ReflectionParameter $parameter) {
        return $parameter->getClass() ? $parameter->getClass()->name : null;
    }, $reflection->getParameters());

    return $parameterTypes[0] ?? '';
}

/**
 * @param \Spatie\Menu\Item $item
 * @param string $type
 *
 * @return bool
 */
function item_matches_type(Item $item, string $type)
{
    if ($type === '') {
        return true;
    }

    return $item instanceof $type;
}

/**
 * @param string $url
 *
 * @return string
 */
function strip_trailing_slashes(string $url) : string
{
    return rtrim($url, '/');
}

/**
 * @param string $url
 *
 * @return array
 */
function url_parts(string $url) : array
{
    $url = parse_url(strip_trailing_slashes($url, '/'));

    return [
        'host' => $url['host'] ?? '',
        'path' => $url['path'] ?? '',
    ];
}
