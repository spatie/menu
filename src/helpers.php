<?php

namespace Spatie\Navigation;

use ReflectionFunction;
use ReflectionParameter;

function callable_parameter_types(callable $callable) : array
{
    $reflection = new ReflectionFunction($callable);

    return array_map(function (ReflectionParameter $parameter) {
        return $parameter->getClass() ? $parameter->getClass()->name : null;
    }, $reflection->getParameters());
}
