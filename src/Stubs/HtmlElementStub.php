<?php

namespace Spatie\Menu\Stubs;

use Spatie\Menu\Traits\HtmlElement;

class HtmlElementStub
{
    use HtmlElement;

    /**
     * @return string
     */
    protected function element() : string
    {
        return 'ul';
    }
}
