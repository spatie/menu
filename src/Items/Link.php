<?php

namespace Spatie\Menu\Items;

use Spatie\Menu\Item;
use Spatie\Menu\Traits\Activatable;
use Spatie\Menu\Traits\HtmlElement;

class Link implements Item
{
    use Activatable, HtmlElement;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $text
     * @param string $url
     */
    private function __construct(string $text, string $url)
    {
        $this->text = $text;
        $this->url = $url;
        $this->active = false;
    }

    /**
     * @param string $text
     * @param string $url
     *
     * @return static
     */
    public static function create(string $text, string $url)
    {
        return new static($text, $url);
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
        return $this->renderHtml(
            'li',
            "<a href=\"{$this->url}\">{$this->text}</a>",
            $this->isActive() ? ['active'] : []
        );
    }
}
