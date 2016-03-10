<?php

namespace Spatie\Menu;

use ReflectionFunction;
use ReflectionParameter;
use Spatie\HtmlElement\Html;
use Spatie\Menu\Items\Link;
use Spatie\Menu\Traits\HtmlAttributes;
use Spatie\Menu\Traits\ParentAttributes;

class Menu implements Item
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

    /**
     * @param \Spatie\Menu\Item[] ...$items
     */
    protected function __construct(Item ...$items)
    {
        $this->items = $items;
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
        return new static(...$items);
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
        if ($this->applyFilters($item) === false) {
            return $this;
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Applies all the currently registered filters to an item.
     *
     * @param \Spatie\Menu\Item $item
     *
     * @return bool
     */
    protected function applyFilters(Item $item) : bool
    {
        foreach ($this->filters as $filter) {
            $type = $this->determineFirstParamaterType($filter);

            if ($type && !$item instanceof $type) {
                continue;
            }

            if ($filter($item) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Map through all the items and return an array containing the result. If you typehint the
     * item parameter in the callable, it wil only be applied to items of that type.
     *
     * @param callable $callable
     *
     * @return array
     */
    public function map(callable $callable) : array
    {
        $type = $this->determineFirstParamaterType($callable);

        $items = $this->items;

        if ($type) {
            $items = array_filter($items, function (Item $item) use ($type) {
                return $item instanceof $type;
            });
        }

        return array_map($callable, $items);
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
        $type = $this->determineFirstParamaterType($callable);

        foreach ($this->items as $item) {
            if ($type && !$item instanceof $type) {
                continue;
            }

            $callable($item);
        }

        return $this;
    }

    /**
     * Register a filter to the menu. When an item is added, all filters will be applied to the
     * item. If a filter returns false, the item won't be added. If you typehint the item
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
     * Determine the type of the first parameter of a callable.
     *
     * @param callable $callable
     *
     * @return string|null
     */
    protected function determineFirstParamaterType(callable $callable)
    {
        $reflection = new ReflectionFunction($callable);

        $parameterTypes = array_map(function (ReflectionParameter $parameter) {
            return $parameter->getClass() ? $parameter->getClass()->name : null;
        }, $reflection->getParameters());

        return $parameterTypes[0] ?? null;
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
     * @param callable $callable
     *
     * @return $this
     */
    public function setActive(callable $callable)
    {
        $type = $this->determineFirstParamaterType($callable);

        foreach ($this->items as $item) {
            if ($type && !$item instanceof $type) {
                continue;
            }

            if ($callable($item)) {
                $item->setActive();
            }
        }

        return $this;
    }

    /**
     * Render the menu in html.
     *
     * @return string
     */
    public function render() : string
    {
        $menu = Html::el(
            'ul',
            $this->attributes()->toArray(),
            $this->map(function (Item $item) {
                return Html::el(
                    $item->isActive() ? 'li.active' : 'li',
                    $item->getParentAttributes(),
                    $item->render()
                );
            })
        );

        return "{$this->prepend}{$menu}{$this->append}";
    }

    public function __toString() : string
    {
        return $this->render();
    }
}
