<?php

namespace Spatie\Menu;

use Spatie\Menu\Items\Link;
use Spatie\Menu\Items\RawHtml;
use Spatie\Menu\Traits\Collection;
use Spatie\Menu\Traits\HtmlElement;
use function Spatie\Menu\callable_parameter_types;

class Menu
{
    use HtmlElement, Collection;

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
     * @param string $text
     * @param string $url
     *
     * @return static
     */
    public function addLink(string $text, string $url)
    {
        return $this->addItem(new Link($text, $url));
    }

    /**
     * @param string $html
     * @param array ...$args
     *
     * @return static
     */
    public function addHtml(string $html, ...$args)
    {
        return $this->addItem(new RawHtml($html, ...$args));
    }

    /**
     * @param callable $callable
     *
     * @return static
     */
    public function manipulate(callable $callable)
    {
        $type = get_callable_parameter_types($callable)[0] ?? null;

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
        $type = get_callable_parameter_types($callable)[0] ?? null;

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
        return $this->renderHtml('ul', $this->mapAndJoin(function (Item $item) {
            return $item->render();
        }));
    }
}
