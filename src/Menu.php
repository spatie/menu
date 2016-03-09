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
    private function __construct(Item ...$items)
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     *
     * @return static
     */
    public static function new(array $items = [])
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
        if ($this->applyFilters($item) === false) {
            return $this;
        }

        $this->items[] = $item;

        return $this;
    }

    protected function applyFilters(Item $item) : bool
    {
        foreach ($this->filters as $filter) {

            $type = $this->determineTypeToManipulate($filter);

            if ($type && ! $item instanceof $type) {
                continue;
            }

            if ($filter($item) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param callable $callable
     *
     * @return array
     */
    public function map(callable $callable) : array
    {
        return array_map($callable, $this->items);
    }

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function each(callable $callable)
    {
        $type = $this->determineTypeToManipulate($callable);

        foreach($this->items as $item) {

            if ($type && ! $item instanceof $type) {
                continue;
            }

            $callable($item);
        }

        return $this;
    }

    /**
     * @param callable $callable
     *
     * @return $this
     */
    public function addFilter(callable $callable)
    {
        $this->filters[] = $callable;

        return $this;
    }

    public function applyToAll(callable $callable)
    {
        $this->each($callable);
        $this->addFilter($callable);

        return $this;
    }

    /**
     * @param callable $callable
     *
     * @return string|null
     */
    protected function determineTypeToManipulate(callable $callable)
    {
        $reflection = new ReflectionFunction($callable);

        $parameterTypes = array_map(function (ReflectionParameter $parameter) {
            return $parameter->getClass() ? $parameter->getClass()->name : null;
        }, $reflection->getParameters());

        return $parameterTypes[0] ?? null;
    }

    /**
     * @param string $prefix
     *
     * @return static
     */
    public function prefixLinks(string $prefix)
    {
        return $this->applyToAll(function (Link $link) use ($prefix) {
            $link->prefix($prefix);
        });
    }

    /**
     * @param string $prepend
     *
     * @return static
     */
    public function prepend(string $prepend)
    {
        $this->prepend = $prepend;

        return $this;
    }

    /**
     * @param string $append
     *
     * @return static
     */
    public function append(string $append)
    {
        $this->append = $append;

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
        $type = $this->determineTypeToManipulate($callable);

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
