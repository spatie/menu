<?php

namespace Spatie\Navigation\Groups;

use Spatie\Navigation\Group as GroupInterface;
use Spatie\Navigation\Traits\Collection;
use Spatie\Navigation\Item;

class Group implements GroupInterface
{
    use Collection;

    /** @var \Spatie\Navigation\Item */
    protected $base;

    /** @var \Spatie\Navigation\Item[] */
    protected $items;

    public function __construct(Item $base, Item ...$items)
    {
        $this->base = $base;
        $this->items = $items ?? [];
    }

    public static function create(Item $base, Item ...$items) : Group
    {
        return new static($base, ...$items);
    }

    public function base() : Item
    {
        return $this->base;
    }

    public function isActive() : bool
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }

    public function render() : string
    {
        return "<li><ul>{$this->renderItems()}</ul></li>";
    }

    public function renderItems() : string
    {
        $items = $this->items->map(function (Item $item) {
            return $item->render;
        });

        return implode('', $items);
    }
}
