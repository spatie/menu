<?php

namespace Spatie\Navigation;

interface Root
{
    public function children() : array;
    public function map(callable $callable) : array;
    public function filter(callable $callable) : array;
}
