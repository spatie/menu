<?php

namespace Spatie\Navigation\Items;

use Spatie\Navigation\Item;
use Spatie\Navigation\Traits\HtmlElement;

class RawHtml implements Item
{
    use HtmlElement;

    /** @var string */
    protected $html;

    /** @var bool */
    protected $active;

    public function __construct(string $html, ...$args)
    {
        $this->html = sprintf($html, ...$args);
        $this->active = false;
    }

    public function html() : string
    {
        return $this->html;
    }

    public function isActive() : bool
    {
        return $this->active;
    }

    public function setActive() : Item
    {
        $this->active = true;

        return $this;
    }

    public function setInactive() : Item
    {
        $this->active = false;

        return $this;
    }

    public function render() : string
    {
        return $this->renderHtml(
            'li',
            $this->html,
            $this->isActive() ? ['active'] : []
        );
    }
}
