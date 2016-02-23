<?php

namespace Spatie\Menu\Helpers;

use Spatie\Menu\Item;
use Spatie\Menu\Traits\HtmlElement;

class MenuItemDisplayer
{
    use HtmlElement;

    protected function element() : string
    {
        return 'li';
    }

    public static function render(Item $item) : string
    {
        $instance = new static();

        $attributes = $item->isActive() ? ['class' => 'active'] : [];

        return $instance->renderHtml($item->render(), $attributes);
    }
}
