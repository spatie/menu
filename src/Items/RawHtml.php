<?php

namespace Spatie\Navigation\Items;

use Spatie\Navigation\Item;
use Spatie\Navigation\Traits\Activatable;
use Spatie\Navigation\Traits\HtmlElement;

class RawHtml implements Item
{
    use Activatable, HtmlElement;

    /**
     * @var string
     */
    protected $html;

    /**
     * @param string $html
     */
    private function __construct(string $html)
    {
        $this->html = $html;
        $this->active = false;
    }

    /**
     * @param string $html
     *
     * @return static
     */
    public static function create(string $html)
    {
        return new static($html);
    }

    /**
     * @return string
     */
    public function html() : string
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->renderHtml(
            'li',
            $this->html,
            $this->isActive() ? ['active'] : []
        );
    }
}
