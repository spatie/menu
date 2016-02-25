<?php

namespace Spatie\Menu;

use Spatie\Menu\Helpers\MenuItemDisplayer;
use Spatie\Menu\Items\Link;
use Spatie\Menu\Items\RawHtml;
use Spatie\Menu\Traits\Collection;
use Spatie\Menu\Traits\HtmlElement;

class Menu implements Item
{
    use Collection, HtmlElement;

    /**
     * @var \Spatie\Menu\Item
     */
    protected $before;

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
     * @param callable $bootstrap
     *
     * @return $this
     */
    public function addMenu(callable $bootstrap)
    {
        $menu = Menu::create();

        $bootstrap($menu);

        $this->addItem($menu);

        return $this;
    }

    /**
     * @param \Spatie\Menu\Item|string $before
     *
     * @return $this
     */
    public function before($before)
    {
        if (is_string($before)) {
            $before = RawHtml::create($before);
        }

        $this->before = $before;

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
    protected function element() : string
    {
        return 'ul';
    }

    /**
     * @return string
     */
    public function render() : string
    {
        $before = empty($this->before) ? '' : $this->before->render();

        $menu = $this->renderHtml(
            $this->mapAndJoin(function (Item $item) {
                return MenuItemDisplayer::render($item);
            })
        );

        return "{$before}{$menu}";
    }
}
