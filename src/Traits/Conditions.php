<?php

namespace Spatie\Menu\Traits;

trait Conditions
{
    /**
     * @param mixed $conditional
     * @return bool
     */
    protected function resolveCondition($conditional)
    {
        return is_callable($conditional) ? $conditional() : $conditional;
    }
}
