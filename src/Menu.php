<?php

namespace Spatie\Navigation;

use Spatie\Navigation\Traits\Collection;
use Spatie\Navigation\Traits\HtmlElement;

class Menu
{
    use HtmlElement, Collection;

    public function __construct(Item ...$items)
    {
        $this->items = $items;
    }

    public static function create(Item ...$items) : Menu
    {
        return new static(...$items);
    }

    public function manipulate(callable $callable) : Menu
    {
        return new static(...$callable($this->items));
    }

    public function render() : string
    {
        return $this->renderHtml('ul', $this->mapAndJoin(function (Item $item) {
            return $item->render();
        }));
    }
}
