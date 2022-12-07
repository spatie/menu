<?php

namespace Spatie\Menu;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Spatie\Menu\Helpers\Reflection;
use Spatie\Menu\Html\Attributes;
use Spatie\Menu\Html\Tag;
use Spatie\Menu\Traits\Conditions as ConditionsTrait;
use Spatie\Menu\Traits\HasHtmlAttributes as HasHtmlAttributesTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;
use Spatie\Menu\Traits\HasTextAttributes as HasAttributesTrait;
use Traversable;

class Menu implements Item, Countable, HasHtmlAttributes, HasParentAttributes, IteratorAggregate
{
    use HasHtmlAttributesTrait;
    use HasParentAttributesTrait;
    use ConditionsTrait;
    use HasAttributesTrait;

    protected array $items = [];

    protected array $filters = [];

    protected string | Item $prepend = '';

    protected string | Item $append = '';

    protected array $wrap = [];

    protected string $activeClass = 'active';

    protected string $exactActiveClass = 'exact-active';

    protected string | null $wrapperTagName = 'ul';

    protected string | null $parentTagName = 'li';

    protected bool $activeClassOnParent = true;

    protected bool $activeClassOnLink = false;

    protected Attributes $htmlAttributes;

    protected Attributes $parentAttributes;

    protected function __construct(Item ...$items)
    {
        $this->items = $items;

        $this->htmlAttributes = new Attributes();
        $this->parentAttributes = new Attributes();
    }

    /**
     * Create a new menu, optionally prefilled with items.
     *
     * @param array $items
     *
     * @return static
     */
    public static function new($items = []): static
    {
        return new static(...array_values($items));
    }

    /**
     * Build a new menu from an array. The callback receives a menu instance as
     * the accumulator, the array item as the second parameter, and the item's
     * key as the third.
     *
     * @param array|\Iterator $items
     * @param callable $callback
     * @param \Spatie\Menu\Menu|null $initial
     *
     * @return static
     */
    public static function build(array | \Iterator $items, callable $callback, self | null $initial = null): static
    {
        return ($initial ?: static::new())->fill($items, $callback);
    }

    /**
     * Fill a menu from an array. The callback receives a menu instance as
     * the accumulator, the array item as the second parameter, and the item's
     * key as the third.
     *
     * @param array|\Iterator $items
     * @param callable $callback
     *
     * @return static
     */
    public function fill(array | \Iterator $items, callable $callback): self
    {
        $menu = $this;

        foreach ($items as $key => $item) {
            $menu = $callback($menu, $item, $key) ?: $menu;
        }

        return $menu;
    }

    /**
     * Add an item to the menu. This also applies all registered filters to the
     * item.
     *
     * @param \Spatie\Menu\Item $item
     *
     * @return $this
     */
    public function add(Item $item): self
    {
        foreach ($this->filters as $filter) {
            $this->applyFilter($filter, $item);
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Add an item to the menu if a (non-strict) condition is met.
     *
     * @param bool|callable $condition
     * @param \Spatie\Menu\Item $item
     *
     * @return $this
     */
    public function addIf(bool | callable $condition, Item $item): self
    {
        if ($this->resolveCondition($condition)) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * Shortcut function to add a plain link to the menu.
     *
     * @param string $url
     * @param string $text
     *
     * @return $this
     */
    public function link(string $url, string $text): self
    {
        return $this->add(Link::to($url, $text));
    }

    /**
     * Shortcut function to add an empty item to the menu.
     *
     * @return $this
     */
    public function empty(): self
    {
        return $this->add(Html::empty());
    }

    /**
     * Add a link to the menu if a (non-strict) condition is met.
     *
     * @param bool|callable $condition
     * @param string $url
     * @param string $text
     *
     * @return $this
     */
    public function linkIf(bool | callable $condition, string $url, string $text): self
    {
        if ($this->resolveCondition($condition)) {
            $this->link($url, $text);
        }

        return $this;
    }

    /**
     * Shortcut function to add raw html to the menu.
     *
     * @param string $html
     * @param array $parentAttributes
     *
     * @return $this
     */
    public function html(string $html, array $parentAttributes = []): self
    {
        return $this->add(Html::raw($html)->setParentAttributes($parentAttributes));
    }

    /**
     * Add a chunk of html if a (non-strict) condition is met.
     *
     * @param bool|callable $condition
     * @param string $html
     * @param array $parentAttributes
     *
     * @return $this
     */
    public function htmlIf(bool | callable $condition, string $html, array $parentAttributes = []): self
    {
        if ($this->resolveCondition($condition)) {
            $this->html($html, $parentAttributes);
        }

        return $this;
    }

    public function submenu(callable | self | Item | string $header, callable | self | null $menu = null): self
    {
        [$header, $menu] = $this->parseSubmenuArgs(func_get_args());

        $menu = $this->createSubmenuMenu($menu);

        return $this->add($menu->prependIf($header, $header));
    }

    public function submenuIf(bool $condition, callable | self | Item | string $header, callable | self | null $menu = null): self
    {
        if ($condition) {
            $this->submenu($header, $menu);
        }

        return $this;
    }

    protected function parseSubmenuArgs($args): array
    {
        if (count($args) === 1) {
            return ['', $args[0]];
        }

        return [$args[0], $args[1]];
    }

    protected function createSubmenuMenu(self | callable $menu): self
    {
        if (is_callable($menu)) {
            $transformer = $menu;
            $menu = $this->blueprint();
            $transformer($menu);
        }

        return $menu;
    }

    protected function createSubmenuHeader(Item | string $header): string
    {
        if ($header instanceof Item) {
            $header = $header->render();
        }

        return $header;
    }

    /**
     * Iterate over all the items and apply a callback. If you typehint the
     * item parameter in the callable, it wil only be applied to items of that
     * type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function each(callable $callable): self
    {
        $type = Reflection::firstParameterType($callable);

        foreach ($this->items as $item) {
            if (! Reflection::itemMatchesType($item, $type)) {
                continue;
            }

            $callable($item);
        }

        return $this;
    }

    /**
     * Register a filter to the menu. When an item is added, all filters will be
     * applied to the item. If you typehint the item parameter in the callable, it
     * will only be applied to items of that type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function registerFilter(callable $callable): self
    {
        $this->filters[] = $callable;

        return $this;
    }

    /**
     * Apply a filter to an item. Returns the result of the filter.
     *
     * @param callable $filter
     * @param \Spatie\Menu\Item $item
     */
    protected function applyFilter(callable $filter, Item $item)
    {
        $type = Reflection::firstParameterType($filter);

        if (! Reflection::itemMatchesType($item, $type)) {
            return;
        }

        // TODO: according to the method description, this should this return a value...?
        $filter($item);
    }

    /**
     * Apply a callable to all existing items, and register it as a filter so it
     * will get applied to all new items too. If you typehint the item parameter
     * in the callable, it wil only be applied to items of that type.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function applyToAll(callable $callable): self
    {
        $this->each($callable);
        $this->registerFilter($callable);

        return $this;
    }

    /**
     * Wrap the entire menu in an html element. This is another level of
     * wrapping above the `wrapperTag`.
     *
     * @param string $element
     * @param array $attributes
     *
     * @return $this
     */
    public function wrap(string $element, array $attributes = []): self
    {
        $this->wrap = [$element, $attributes];

        return $this;
    }

    /**
     * Determine whether the menu is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        if ($this->prepend && $this->prepend instanceof Item && $this->prepend->isActive()) {
            return true;
        }

        return false;
    }

    /**
     * A menu can be active but not exact-active, unless its prepend is.
     *
     * @return bool
     */
    public function isExactActive(): bool
    {
        if (! $this->prepend) {
            return false;
        }

        // Kind of hacky, should be handled differently in the next major version
        if (! method_exists($this->prepend, 'isExactActive')) {
            return false;
        }

        return $this->prepend->isExactActive();
    }

    /**
     * Set multiple items in the menu as active based on a callable that filters
     * through items. If you typehint the item parameter in the callable, it will
     * only be applied to items of that type.
     *
     * @param callable|string $urlOrCallable
     * @param string $root
     *
     * @return $this
     */
    public function setActive(callable | string $urlOrCallable, string $root = '/'): self
    {
        if (is_string($urlOrCallable)) {
            return $this->setActiveFromUrl($urlOrCallable, $root);
        }

        return $this->setActiveFromCallable($urlOrCallable);
    }

    /**
     * Set the class name that will be used on exact-active items for this menu.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setExactActiveClass(string $class)
    {
        $this->exactActiveClass = $class;

        return $this;
    }

    /**
     * Set all relevant children active based on the current request's URL.
     *
     * /, /about, /contact => request to /about will set the about link active.
     *
     * /en, /en/about, /en/contact => request to /en won't set /en active if the
     *                                request root is set to /en.
     *
     * @param string $url  The current request url.
     * @param string $root If the link's URL is an exact match with the request
     *                     root, the link won't be set active. This behavior is
     *                     to avoid having home links active on every request.
     *
     * @return $this
     */
    public function setActiveFromUrl(string $url, string $root = '/'): self
    {
        $this->applyToAll(function (Menu $menu) use ($url, $root) {
            $menu->setActiveFromUrl($url, $root);
        });

        if ($this->prepend instanceof Activatable) {
            $this->prepend->determineActiveForUrl($url, $root);
        }

        $this->applyToAll(function (Activatable $item) use ($url, $root) {
            $item->determineActiveForUrl($url, $root);
        });

        return $this;
    }

    public function setActiveFromCallable(callable $callable): self
    {
        $this->applyToAll(function (Menu $menu) use ($callable) {
            $menu->setActiveFromCallable($callable);
        });

        $type = Reflection::firstParameterType($callable);

        $this->applyToAll(function (Activatable $item) use ($callable, $type) {
            /** @var \Spatie\Menu\Activatable|\Spatie\Menu\Item $item */
            if (! Reflection::itemMatchesType($item, $type)) {
                return;
            }

            if ($callable($item)) {
                $item->setActive();
                /** @psalm-suppress UndefinedInterfaceMethod */
                $item->setExactActive();
            }
        });

        return $this;
    }

    /**
     * Set the class name that will be used on active items for this menu.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setActiveClass(string $class): self
    {
        $this->activeClass = $class;

        return $this;
    }

    /**
     * Add a class to all items in the menu.
     *
     * @param string $class
     *
     * @return $this
     */
    public function addItemClass(string $class): self
    {
        $this->applyToAll(function (HasHtmlAttributes $link) use ($class) {
            $link->addClass($class);
        });

        return $this;
    }

    /**
     * Set an attribute on all items in the menu.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setItemAttribute(string $attribute, string $value = ''): self
    {
        $this->applyToAll(function (HasHtmlAttributes $link) use ($attribute, $value) {
            $link->setAttribute($attribute, $value);
        });

        return $this;
    }

    /**
     * Add a parent class to all items in the menu.
     *
     * @param string $class
     *
     * @return $this
     */
    public function addItemParentClass(string $class): self
    {
        $this->applyToAll(function (HasParentAttributes $item) use ($class) {
            $item->addParentClass($class);
        });

        return $this;
    }

    /**
     * Add a parent attribute to all items in the menu.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setItemParentAttribute(string $attribute, string $value = ''): self
    {
        $this->applyToAll(function (HasParentAttributes $item) use ($attribute, $value) {
            $item->setParentAttribute($attribute, $value);
        });

        return $this;
    }

    /**
     * Set tag for items wrapper.
     *
     * @param string|null $wrapperTagName
     * @return $this
     */
    public function setWrapperTag(string | null $wrapperTagName = null): self
    {
        $this->wrapperTagName = $wrapperTagName;

        return $this;
    }

    /**
     * Unset tag for items wrapper.
     *
     * @return $this
     */
    public function withoutWrapperTag(): self
    {
        $this->wrapperTagName = null;

        return $this;
    }

    /**
     * Set the parent tag name.
     *
     * @param string|null $parentTagName
     * @return $this
     */
    public function setParentTag(string | null $parentTagName = null): self
    {
        $this->parentTagName = $parentTagName;

        return $this;
    }

    /**
     * Render items without a parent tag.
     *
     * @return $this
     */
    public function withoutParentTag(): self
    {
        $this->parentTagName = null;

        return $this;
    }

    /**
     * Set whether active class should (also) be on link.
     *
     * @param bool $activeClassOnLink
     *
     * @return $this
     */
    public function setActiveClassOnLink(bool $activeClassOnLink = true): self
    {
        $this->activeClassOnLink = $activeClassOnLink;

        return $this;
    }

    /**
     * Set whether active class should (also) be on parent.
     *
     * @param $activeClassOnParent
     *
     * @return $this
     */
    public function setActiveClassOnParent(bool $activeClassOnParent = true): self
    {
        $this->activeClassOnParent = $activeClassOnParent;

        return $this;
    }

    /**
     * @param bool $condition
     * @param callable $callable
     *
     * @return $this
     */
    public function if(bool $condition, callable $callable)
    {
        return $condition ? $callable($this) : $this;
    }

    /**
     * Create a empty blueprint of the menu (copies `filters` and `activeClass`).
     *
     * @return static
     */
    public function blueprint(): static
    {
        $clone = new static();

        $clone->filters = $this->filters;
        $clone->activeClass = $this->activeClass;

        return $clone;
    }

    /**
     * Render the menu.
     *
     * @return string
     */
    public function render(): string
    {
        $tag = $this->wrapperTagName
            ? new Tag($this->wrapperTagName, $this->htmlAttributes)
            : null;

        $contents = array_map([$this, 'renderItem'], $this->items);

        $wrappedContents = $tag ? $tag->withContents($contents) : implode('', $contents);

        if ($this->prepend instanceof Item && $this->prepend->isActive()) {
            $this->prepend = $this->renderActiveClassOnLink($this->prepend);
        }

        $menu = $this->renderPrepend().$wrappedContents.$this->renderAppend();

        if (! empty($this->wrap)) {
            return Tag::make($this->wrap[0], new Attributes($this->wrap[1]))->withContents($menu);
        }

        return $menu;
    }

    protected function renderItem(Item $item): string
    {
        $attributes = new Attributes();

        if (method_exists($item, 'beforeRender')) {
            $item->beforeRender();
        }

        if (method_exists($item, 'willRender') && $item->willRender() === false) {
            return '';
        }

        if ($item->isActive()) {
            if ($this->activeClassOnParent) {
                $attributes->addClass($this->activeClass);

                /** @psalm-suppress UndefinedInterfaceMethod */
                if ($item->isExactActive()) {
                    $attributes->addClass($this->exactActiveClass);
                }
            }

            $item = $this->renderActiveClassOnLink($item);
        }

        if ($item instanceof HasParentAttributes) {
            $attributes->setAttributes($item->parentAttributes());
        }

        if (! $this->parentTagName) {
            return $item->render();
        }

        return Tag::make($this->parentTagName, $attributes)->withContents($item->render());
    }

    protected function renderActiveClassOnLink(Item $item): Item
    {
        if ($this->activeClassOnLink && $item instanceof HasHtmlAttributes && ! $item instanceof Menu) {
            $item->addClass($this->activeClass);

            /** @psalm-suppress UndefinedInterfaceMethod */
            if ($item->isExactActive()) {
                $item->addClass($this->exactActiveClass);
            }
        }

        return $item;
    }

    /**
     * The amount of items in the menu.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
