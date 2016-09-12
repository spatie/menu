<?php

namespace Spatie\Menu;

use Spatie\HtmlElement\Attributes;
use Spatie\HtmlElement\HtmlElement;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\HasUrl as HasUrlTrait;
use Spatie\Menu\Traits\HasHtmlAttributes as HasHtmlAttributesTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;

class Link implements Item, Activatable, HasHtmlAttributes, HasParentAttributes, HasUrl
{
    use ActivatableTrait, HasUrlTrait, HasHtmlAttributesTrait, HasParentAttributesTrait;

    /** @var string */
    protected $text;

    /** @var \Spatie\Menu\Url */
    protected $url;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $htmlAttributes;

    /** @var \Spatie\HtmlElement\Attributes */
    protected $parentAttributes;

    /**
     * @param string $url
     * @param string $text
     */
    protected function __construct(string $url, string $text)
    {
        $this->url = new Url($url);
        $this->text = $text;
        $this->active = false;
        $this->htmlAttributes = new Attributes();
        $this->parentAttributes = new Attributes();
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
            "a[href={$this->getUrl()->url()}]",
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
