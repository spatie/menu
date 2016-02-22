<?php

namespace Spatie\Navigation\Groups;

use Spatie\Navigation\Items\Link;
use Spatie\Navigation\Traits\Collection;
use Spatie\Navigation\Item;
use Spatie\Navigation\Traits\HtmlElement;

class SubMenu implements Item
{
    use HtmlElement, Collection;

    /**
     * @var \Spatie\Navigation\Item
     */
    protected $base;

    /**
     * @param \Spatie\Navigation\Item $base
     * @param \Spatie\Navigation\Item[] ...$items
     */
    private function __construct(Item $base, Item ...$items)
    {
        $this->base = $base;
        $this->items = $items ?? [];
    }

    /**
     * @param \Spatie\Navigation\Item $base
     * @param array $items
     *
     * @return static
     */
    public static function create(Item $base, array $items = [])
    {
        return new static($base, ...$items);
    }

    /**
     * @return \Spatie\Navigation\Items\Link
     */
    public function base() : Link
    {
        return $this->base;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        if ($this->base->isActive()) {
            return true;
        }

        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->renderHtml(
            'li',
            "{$this->base->render()}<ul>{$this->renderItems()}</ul>"
        );
    }

    /**
     * @return string
     */
    public function renderItems() : string
    {
        return $this->mapAndJoin(function (Item $item) {
            return "<li>{$item->render()}</li>";
        });
    }
}
