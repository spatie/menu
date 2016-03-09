<?php

namespace Spatie\Menu\Items;

use Spatie\HtmlElement\Html as HtmlElement;
use Spatie\Menu\Item;
use Spatie\Menu\Traits\Activatable;
use Spatie\Menu\Traits\HtmlAttributes;
use Spatie\Menu\Traits\ParentAttributes;

class Link implements Item
{
    use Activatable, HtmlAttributes, ParentAttributes;

    /** @var string */
    protected $text;

    /** @var string */
    protected $url;

    /**
     * @param string $url
     * @param string $text
     */
    private function __construct(string $url, string $text)
    {
        $this->url = $url;
        $this->text = $text;
        $this->active = false;
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
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * Return a segment of the link's URL. This function works for both absolute and relative URL's.
     * The index is a 1-index based number. Trailing and double slashes are ignored.
     *
     * Example: (new Link('Open Source', 'https://spatie.be/opensource'))->segment(1) => 'opensource'
     *
     * @param int $index
     *
     * @return string|null
     */
    public function segment(int $index)
    {
        $path = parse_url($this->url)['path'] ?? '';

        $segments = array_values(
            array_filter(
                explode('/', $path),
                function ($value) {
                    return $value !== '';
                }
            )
        );

        return $segments[$index-1] ?? null;
    }

    /**
     * @param string $prefix
     *
     * @return static
     */
    public function prefix(string $prefix)
    {
        $this->url = $prefix . '/' . ltrim($this->url, '/');

        return $this;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return HtmlElement::el(
            "a[href={$this->url}]",
            $this->attributes()->toArray(),
            $this->text
        );
    }
}
