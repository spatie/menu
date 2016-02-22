<?php

namespace Spatie\Navigation\Traits;

use Spatie\Navigation\Item;

trait Collection
{
    /** @var array */
    protected $items = [];

    public function items() : array
    {
        return $this->items;
    }

    /** @return static */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /** @return static */
    public function fill(Item ...$items)
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function map(callable $callable) : array
    {
        return array_map($callable, $this->items);
    }

    public function mapAndJoin(callable $callable) : string
    {
        return implode('', $this->map($callable));
    }
}
