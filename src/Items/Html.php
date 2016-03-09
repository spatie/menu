<?php

namespace Spatie\Menu\Items;

use Spatie\Menu\Item;
use Spatie\Menu\Traits\Activatable;
use Spatie\Menu\Traits\HtmlElement;
use Spatie\Menu\Traits\ParentAttributes;

class Html implements Item
{
    use Activatable, ParentAttributes;

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
    public static function raw(string $html)
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
        return $this->html;
    }
}
