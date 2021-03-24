<?php

namespace Spatie\Menu\Traits;

trait Conditions
{
    protected function resolveCondition(mixed $conditional): mixed
    {
        return is_callable($conditional) ? $conditional() : $conditional;
    }
}
