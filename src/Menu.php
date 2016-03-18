<?php

namespace Spatie\Menu;

use Countable;
use Spatie\HtmlElement\HtmlElement;
use Spatie\Menu\Traits\HtmlAttributes;
use Spatie\Menu\Traits\ParentAttributes;

class Menu implements Countable, Item
{
    use HtmlAttributes, ParentAttributes;

    /** @var array */
    protected $items = [];

    /** @var string */
    protected $prepend = '';

    /** @var string */
    protected $append = '';

    /** @var array */
    protected $filters = [];

    /** @var string */
    protected $activeClass = 'active';

    /**
     * @param \Spatie\Menu\Item[] ...$items
     */
    protected function __construct(Item ...$items)
    {
        $this->items = $items;

        $this->bootHtmlAttributes();
        $this->bootParentAttributes();
    }

    /**
     * Create a new menu, optionally prefilled with items.
     *
     * @param array $items
     *
     * @return static
     */
    public static function new(array $items = [])
    {
        return new static(...array_values($items));
    }

    /**
     * Add an item to the menu. This also applies all registered filters on the item. If a filter
     * returns false, the item won't be added.
     *
     * @param \Spatie\Menu\Item $item
     *
     * @return $this
     */
    public function add(Item $item)
    {
        foreach ($this->filters as $filter) {
            $this->applyFilter($filter, $item);
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Shortcut function to add a plain link to the menu.
     *
     * @param string $url
     * @param string $text
     *
     * @return \Spatie\Menu\Menu
     */
    public function link(string $url, string $text)
    {
        return $this->add(Link::to($url, $text));
    }

    /**
     * Apply a filter to an item. Returns the result of the filter.
     *
     * @param callable $filter
     * @param \Spatie\Menu\Item $item
     */
    protected function applyFilter(callable $filter, Item $item)
    {
        $type = first_parameter_type($filter);

        if (!item_matches_type($item, $type)) {
            return;
        }

        $filter($item);
    }

    /**
     * Iterate over all the items and apply a callback. If you typehint the
     * item parameter in the callable, it wil only be applied to items of that type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function each(callable $callable)
    {
        $type = first_parameter_type($callable);

        foreach ($this->items as $item) {
            if (!item_matches_type($item, $type)) {
                continue;
            }

            $callable($item);
        }

        return $this;
    }

    /**
     * Register a filter to the menu. When an item is added, all filters will be applied to the
     * item. If you typehint the item
     * parameter in the callable, it wil only be applied to items of that type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function registerFilter(callable $callable)
    {
        $this->filters[] = $callable;

        return $this;
    }

    /**
     * Apply a callable to all existing items, and register it as a filter so it will get applied
     * to all new items too. If you typehint the item parameter in the callable, it wil only be
     * applied to items of that type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function applyToAll(callable $callable)
    {
        $this->each($callable);
        $this->registerFilter($callable);

        return $this;
    }

    /**
     * Prepend a string of html to the menu on render.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function prefixLinks(string $prefix)
    {
        return $this->applyToAll(function (Link $link) use ($prefix) {
            $link->prefix($prefix);
        });
    }

    /**
     * Prepend the menu with a string of html on render.
     *
     * @param string $prepend
     *
     * @return $this
     */
    public function prepend(string $prepend)
    {
        $this->prepend = $prepend;

        return $this;
    }

    /**
     * Prepend the menu with a string of html on render if a certain condition is met.
     *
     * @param bool $condition
     * @param string $prepend
     *
     * @return $this
     */
    public function prependIf(bool $condition, string $prepend)
    {
        if ($condition) {
            return $this->prepend($prepend);
        }

        return $this;
    }

    /**
     * Append a string of html to the menu on render.
     *
     * @param string $append
     *
     * @return $this
     */
    public function append(string $append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Append the menu with a string of html on render if a certain condition is met.
     *
     * @param bool $condition
     * @param string $append
     *
     * @return static
     */
    public function appendIf(bool $condition, string $append)
    {
        if ($condition) {
            return $this->append($append);
        }

        return $this;
    }

    /**
     * Determine whether the menu is active.
     *
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
     * Set multiple items in the menu as active based on a callable that filters through items.
     * If you typehint the item parameter in the callable, it wil only be applied to items of
     * that type.
     *
     * @param callable|string $patternOrCallable
     * @param string $root
     *
     * @return $this
     */
    public function setActive($patternOrCallable, string $root = '/')
    {
        if (is_string($patternOrCallable)) {
            return $this->setActiveFromUrl($patternOrCallable, $root);
        }

        if (is_callable($patternOrCallable)) {
            return $this->setActiveFromCallable($patternOrCallable);
        }

        throw new \InvalidArgumentException('`setActive` requires a pattern or a callable');
    }

    /**
     * Set all relevant children active based on the current request's URL.
     *
     * /, /about, /contact => request to /about will set the about link active.
     *
     * /en, /en/about, /en/contact => request to /en won't set /en active if the request root
     *                                is set to /en.
     *
     * @param string $url The current request url.
     * @param string $root If the link's URL is an exact match with the request root, the
     *                            link won't be set active. This behavior is to avoid having home
     *                            links active on every request.
     *
     * @return $this
     */
    public function setActiveFromUrl(string $url, string $root = '/')
    {
        $requestUrl = url_parts($url);
        $requestRoot = strip_trailing_slashes($root, '/');

        $this->applyToAll(function (Link $link) use ($requestUrl, $requestRoot) {

            $url = url_parts($link->getUrl());

            // If the menu item is on a different host it can't be active.
            if ($url['host'] !== '' && $url['host'] !== $requestUrl['host']) {
                return;
            }

            // If the request url or the link url is on the root, only set exact matches active.
            if (
                $requestUrl['path'] === $requestRoot ||
                $url['path'] === $requestRoot
            ) {
                if ($url['path'] === $requestUrl['path']) {
                    $link->setActive();
                }

                return;
            }

            // The menu item is active if it's path starts with the request path.
            if (strpos($url['path'], $requestUrl['path']) === 0) {
                $link->setActive();
            };
        });

        return $this;
    }

    /**
     * @param callable $callable
     *
     * @return $this
     */
    public function setActiveFromCallable(callable $callable)
    {
        $type = first_parameter_type($callable);

        return $this->applyToAll(function (Item $item) use ($callable, $type) {
            if (!item_matches_type($item, $type)) {
                return;
            }

            if ($callable($item)) {
                $item->setActive();
            }
        });
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setActiveClass(string $class)
    {
        $this->activeClass = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        $contents = HtmlElement::render(
            'ul',
            $this->htmlAttributes->toArray(),
            array_map(function (Item $item) {
                return HtmlElement::render(
                    $item->isActive() ? "li.{$this->activeClass}" : 'li',
                    $item->getParentAttributes(),
                    $item->render()
                );
            }, $this->items)
        );

        return "{$this->prepend}{$contents}{$this->append}";
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
