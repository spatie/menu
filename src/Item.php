<?php

namespace Spatie\Navigation;

interface Item extends Node
{
    public function setActive() : Item;
    public function setInactive() : Item;
}
