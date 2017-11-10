<?php

namespace Spatie\Menu\Helpers;

use Spatie\Menu\Item;
use ReflectionFunction;
use ReflectionParameter;

class Reflection
{
    public static function firstParameterType(callable $callable): string
    {
        // # 58 - Allow invokable classes to be used as filters
        if (is_object($callable)) {
            $reflection = new \ReflectionObject($callable);
            $parameters = $reflection->getMethod('__invoke')->getParameters();
        } else {
            $reflection = new ReflectionFunction($callable);
            $parameters = $reflection->getParameters();
        }

        $parameterTypes = array_map(function (ReflectionParameter $parameter) {
            return $parameter->getClass() ? $parameter->getClass()->name : null;
        }, $parameters);

        return $parameterTypes[0] ?? '';
    }

    public static function itemMatchesType(Item $item, string $type): bool
    {
        if ($type === '') {
            return true;
        }

        return $item instanceof $type;
    }
}
