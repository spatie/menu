<?php

namespace Spatie\Navigation\Collections;

use Spatie\Navigation\Node;
use Spatie\Navigation\Root as RootInterface;

class Root implements RootInterface
{
    /** @var \Spatie\Navigation\Node[] */
    protected $children = [];

    public function __construct(Node ...$children)
    {
        $this->children = $children;
    }

    public function children() : array
    {
        return $this->children;
    }

    public function map(callable $callable) : array
    {
        return array_map($callable, $this->children);
    }

    public function filter(callable $callable) : array
    {
        return array_values(array_filter($this->children, $callable));
    }

    public function isActive() : bool
    {
        foreach ($this->children as $child) {
            if ($child->isActive()) {
                return true;
            }
        }

        return false;
    }

    public function add(Node $child) : Group
    {
        $this->children[] = $child;

        return $this;
    }

    public function fill(Node ...$children) : Group
    {
        $this->children = array_merge($this->children, $children);

        return $this;
    }
}
