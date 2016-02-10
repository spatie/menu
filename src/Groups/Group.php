<?php

namespace Spatie\Navigation\Groups;

use Spatie\Navigation\Group as GroupInterface;
use Spatie\Navigation\Node;

class Group implements GroupInterface
{
    /** @var array */
    protected $children = [];

    public function __construct(Node ...$node)
    {
        $this->children = $node;
    }

    public function add(Node $child) : Group
    {
        $this->children[] = $child;

        return $this;
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
}
