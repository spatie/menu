<?php

namespace Spatie\Navigation;

interface Item
{
    public function isActive() : bool;
    public function render() : string;
}
