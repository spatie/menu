<?php

namespace Spatie\Navigation;

interface Displayer
{
    public function display(Node $node) : string;
}
