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
        foreach($this->items as $item) {
            $callable($item);
        }

        return $this;
    }

    public function render() : string
    {
        return $this->renderHtml('ul', $this->mapAndJoin(function (Item $item) {
            return $item->render();
        }));
    }
}
