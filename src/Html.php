<?php

namespace Spatie\Menu;

use Spatie\HtmlElement\Attributes;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;

class Html implements Item, Activatable, HasParentAttributes
{
    use ActivatableTrait, HasParentAttributesTrait;

    /** @var string */
    protected $html;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $parentAttributes;

    /**
     * @param string $html
     */
    protected function __construct(string $html)
    {
        $this->html = $html;
        $this->active = false;
        $this->parentAttributes = new Attributes();
    }

    /**
     * Create an item containing a chunk of raw html.
     *
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
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $url
     */
    public function determineActiveForUrl(string $url)
    {
        return;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->html;
    }
}
