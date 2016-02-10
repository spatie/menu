<?php

namespace Spatie\Navigation;

interface Group extends Node
{
    public function children() : array;
    public function map(callable $callable) : array;
}
