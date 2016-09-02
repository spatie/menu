<?php

namespace Spatie\Menu;

use Spatie\HtmlElement\HtmlElement;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\HasUrl as HasUrlTrait;
use Spatie\Menu\Traits\HtmlAttributes;
use Spatie\Menu\Traits\ParentAttributes;

class Link implements Item, Activatable, HasHtmlAttributes, HasParentAttributes, HasUrl
{
    use ActivatableTrait, HasUrlTrait, HtmlAttributes, ParentAttributes;

    /** @var string */
    protected $text;

    /** @var string */
    protected $url;

    /** @var array */
    protected $prefixes = [];

    /**
     * @param string $url
     * @param string $text
     */
    protected function __construct(string $url, string $text)
    {
        $this->url = $url;
        $this->text = $text;
        $this->active = false;

        $this->initializeHtmlAttributes();
        $this->initializeParentAttributes();
    }

    /**
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public static function to(string $url, string $text)
    {
        return new static($url, $text);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return HtmlElement::render(
            "a[href={$this->getUrl()}]",
            $this->htmlAttributes->toArray(),
            $this->text
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
