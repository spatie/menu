<?php

namespace Spatie\Navigation;

use Spatie\Navigation\Traits\Collection;
use Spatie\Navigation\Traits\HtmlElement;
use function Spatie\Navigation\callable_parameter_types;

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
        $type = callable_parameter_types($callable)[0] ?? null;

        foreach($this->items as $item) {

            if ($type && ! $item instanceof $type) {
                continue;
            }

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
