<?php

namespace Spatie\Menu\Traits;

use ReflectionFunction;
use ReflectionParameter;
use Spatie\Menu\Item;

trait Collection
{
    /** @var array */
    protected $items = [];

    public function items() : array
    {
        return $this->items;
    }

    /** @return static */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /** @return static */
    public function fill(Item ...$items)
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function map(callable $callable) : array
    {
        return array_map($callable, $this->items);
    }

    public function mapAndJoin(callable $callable) : string
    {
        return implode('', $this->map($callable));
    }

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function manipulate(callable $callable)
    {
        $type = $this->getTypeToManipulate($callable);

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
     * @return string|null
     */
    protected function getTypeToManipulate(callable $callable)
    {
        $reflection = new ReflectionFunction($callable);

        $parameterTypes = array_map(function (ReflectionParameter $parameter) {
            return $parameter->getClass() ? $parameter->getClass()->name : null;
        }, $reflection->getParameters());

        return $parameterTypes[0] ?? null;
    }
}
