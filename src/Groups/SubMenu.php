<?php

namespace Spatie\Menu\Groups;

use Spatie\Menu\Items\Link;
use Spatie\Menu\Traits\Collection;
use Spatie\Menu\Item;
use Spatie\Menu\Traits\HtmlElement;

class SubMenu implements Item
{
    use HtmlElement, Collection;

    /**
     * @var \Spatie\Menu\Item
     */
    protected $base;

    /**
     * @param \Spatie\Menu\Item $base
     * @param \Spatie\Menu\Item[] ...$items
     */
    private function __construct(Item $base, Item ...$items)
    {
        $this->base = $base;
        $this->items = $items ?? [];
    }

    /**
     * @param \Spatie\Menu\Item $base
     * @param array $items
     *
     * @return static
     */
    public static function create(Item $base, array $items = [])
    {
        return new static($base, ...$items);
    }

    /**
     * @return \Spatie\Menu\Items\Link
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
