<?php

namespace Spatie\Menu;

use Spatie\HtmlElement\Html;
use Spatie\Menu\Helpers\MenuItemDisplayer;
use Spatie\Menu\Items\Link;
use Spatie\Menu\Items\RawHtml;
use Spatie\Menu\Traits\Collection;
use Spatie\Menu\Traits\HtmlAttributes;

class Menu implements Item
{
    use Collection, HtmlAttributes;

    /** @var string */
    protected $before = '';

    /** @var string */
    protected $after = '';

    /** @var string */
    protected $linkPrefix;

    /**
     * @param \Spatie\Menu\Item[] ...$items
     */
    private function __construct(Item ...$items)
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     *
     * @return static
     */
    public static function create(array $items = [])
    {
        return new static(...$items);
    }

    /**
     * @param \Spatie\Menu\Item $item
     *
     * @return static
     */
    public function add(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public function addLink(string $url, string $text)
    {
        return $this->addItem(Link::create($this->prefixLink($url), $text));
    }

    /**
     * @param string $prefix
     *
     * @return static
     */
    public function setLinkPrefix(string $prefix)
    {
        $this->linkPrefix = rtrim($prefix, '/');

        return $this;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function prefixLink(string $url) : string
    {
        return empty($this->linkPrefix) ? $url : $this->linkPrefix . '/' . trim($url, '/');
    }

    /**
     * @param string $html
     *
     * @return static
     */
    public function addHtml(string $html)
    {
        return $this->addItem(RawHtml::create($html));
    }

    /**
     * @param string $before
     *
     * @return static
     */
    public function before(string $before)
    {
        $this->before = $before;

        return $this;
    }

    /**
     * @param string $after
     *
     * @return static
     */
    public function after(string $after)
    {
        $this->after = $after;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function setActive(callable $callable)
    {
        $type = $this->getTypeToManipulate($callable);

        foreach($this->items as $item) {

            if ($type && ! $item instanceof $type) {
                continue;
            }

            if ($callable($item)) {
                $item->setActive();
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        $menu = Html::el('ul', $this->attributes->toArray(), $this->map(function (Item $item) {
            return MenuItemDisplayer::render($item);
        }));

        return "{$this->before}{$menu}{$this->after}";
    }
}
