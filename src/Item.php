<?php

namespace Spatie\Menu;

interface Item
{
    public function isActive() : bool;
    public function render() : string;
}
