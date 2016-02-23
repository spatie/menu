<?php

namespace Spatie\Menu;

use ReflectionFunction;
use ReflectionParameter;
use Spatie\Menu\Items\Link;
use Spatie\Menu\Items\RawHtml;
use Spatie\Menu\Traits\Collection;
use Spatie\Menu\Traits\HtmlElement;

class Menu
{
    use HtmlElement, Collection;

    /** @var \Spatie\Menu\Item */
    protected $header;

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
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public function addLink(string $url, string $text)
    {
        return $this->addItem(Link::create($url, $text));
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
     * @param \Spatie\Menu\Item|string $header
     *
     * @return $this
     */
    public function setHeader($header)
    {
        if (is_string($header)) {
            $header = RawHtml::create($header);
        }

        $this->header = $header;

        return $this;
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

    /**
     * @return string
     */
    public function render() : string
    {
        $header = $this->header ? $this->header->render() : '';

        $menu = $this->renderHtml('ul', $this->mapAndJoin(function (Item $item) {
            return $item->render();
        }));

        return $header . $menu;
    }
}
