<?php

namespace Spatie\Menu;

use ReflectionFunction;
use ReflectionParameter;

/**
 * Determine the type of the first parameter of a callable.
 *
 * @param callable $callable
 *
 * @return string|null
 */
function first_parameter_type(callable $callable)
{
    $reflection = new ReflectionFunction($callable);

    $parameterTypes = array_map(function (ReflectionParameter $parameter) {
        return $parameter->getClass() ? $parameter->getClass()->name : null;
    }, $reflection->getParameters());

    return $parameterTypes[0] ?? null;
}
