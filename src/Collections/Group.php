<?php

namespace Spatie\Navigation\Collections;

use Spatie\Navigation\Group as GroupInterface;
use Spatie\Navigation\Node;

class Group implements GroupInterface
{
    /** @var \Spatie\Navigation\Node */
    protected $base;

    /** @var \Spatie\Navigation\Node[] */
    protected $children = [];

    public function __construct(Node $base, Node ...$children)
    {
        $this->base = $base;
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

    public function base() : Node
    {
        return $this->base;
    }
}
