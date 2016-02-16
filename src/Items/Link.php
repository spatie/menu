<?php

namespace Spatie\Navigation\Items;

use Spatie\Navigation\Item;
use Spatie\Navigation\Traits\HtmlElement;

class Link implements Item
{
    use HtmlElement;

    /** @var string */
    protected $text;

    /** @var string */
    protected $url;

    /** @var bool */
    protected $active;

    public function __construct(string $text, string $url)
    {
        $this->text = $text;
        $this->url = $url;
        $this->active = false;
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

    public function text() : string
    {
        return $this->text;
    }

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

    public function render() : string
    {
        return $this->renderHtml(
            'li',
            "<a href=\"{$this->url}\">{$this->text}</a>",
            $this->isActive() ? ['active'] : []
        );
    }
}
