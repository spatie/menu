<?php

namespace Spatie\Menu\Items;

use Spatie\HtmlElement\Html;
use Spatie\Menu\Item;
use Spatie\Menu\Traits\Activatable;
use Spatie\Menu\Traits\HtmlAttributes;

class Link implements Item
{
    use Activatable, HtmlAttributes;

    /** @var string */
    protected $text;

    /** @var string */
    protected $url;

    /**
     * @param string $url
     * @param string $text
     */
    private function __construct(string $url, string $text, array $attributes = [])
    {
        $this->url = $url;
        $this->text = $text;
        $this->attributes = $attributes;
        $this->active = false;
    }

    /**
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public static function create(string $url, string $text)
    {
        return new static($url, $text);
    }

    /**
     * @return string
     */
    public function text() : string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function url() : string
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
     * @return string
     */
    public function render() : string
    {
        return Html::el('a', array_merge($this->attributes(), ['href' => $this->url]), $this->text());
    }
}
