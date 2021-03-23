<?php

namespace Spatie\Menu;

use Spatie\Menu\Html\Attributes;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;

class Html implements Item, Activatable, HasParentAttributes
{
    use ActivatableTrait;
    use HasParentAttributesTrait;

    protected string | null $url = null;

    protected bool $active = false;

    protected Attributes $parentAttributes;

    protected function __construct(protected string $html)
    {
        $this->parentAttributes = new Attributes();
    }

    /**
     * Create an item containing a chunk of raw html.
     *
     * @param string $html
     *
     * @return static
     */
    public static function raw(string $html): static
    {
        return new static($html);
    }

    /**
     * Create an empty item.
     *
     * @return static
     */
    public static function empty(): static
    {
        return new static('');
    }

    public function html(): string
    {
        return $this->html;
    }

    public function render(): string
    {
        return $this->html;
    }
}
