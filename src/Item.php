<?php

namespace Spatie\Menu;

interface Item
{
    public function isActive() : bool;
    public function getParentAttributes() : array;
    public function render() : string;
}
