<?php

namespace Spatie\Navigation;

interface Displayer
{
    public function display(Root $root) : string;
}
