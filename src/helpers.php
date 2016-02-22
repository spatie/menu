<?php

namespace Spatie\Menu;

use ReflectionFunction;
use ReflectionParameter;

function get_callable_parameter_types(callable $callable) : array
{
    $reflection = new ReflectionFunction($callable);

    return array_map(function (ReflectionParameter $parameter) {
        return $parameter->getClass() ? $parameter->getClass()->name : null;
    }, $reflection->getParameters());
}
