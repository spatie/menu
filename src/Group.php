<?php

namespace Spatie\Navigation;

interface Group extends Item
{
    public function base() : Item;
    public function items() : array;
}
