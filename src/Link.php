<?php

namespace Spatie\Menu;

use Spatie\Menu\Html\Attributes;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\Conditions as ConditionsTrait;
use Spatie\Menu\Traits\HasHtmlAttributes as HasHtmlAttributesTrait;
use Spatie\Menu\Traits\HasParentAttributes as HasParentAttributesTrait;
use Spatie\Menu\Traits\HasTextAttributes as HasAttributesTrait;

class Link implements Item, HasHtmlAttributes, HasParentAttributes, Activatable
{
    use ActivatableTrait;
    use HasHtmlAttributesTrait;
    use HasParentAttributesTrait;
    use ConditionsTrait;
    use HasAttributesTrait;

    protected string $prepend = '';

    protected string $append = '';

    protected bool $active = false;

    protected Attributes $htmlAttributes;

    protected Attributes $parentAttributes;

    protected function __construct(
        protected string | null $url,
        protected string $text,
    ) {
        $this->htmlAttributes = new Attributes();
        $this->parentAttributes = new Attributes();
    }

    public static function to(string $url, string $text): static
    {
        return new static($url, $text);
    }

    public function text(): string
    {
        return $this->text;
    }

    public function render(): string
    {
        $attributes = new Attributes(['href' => $this->url]);
        $attributes->mergeWith($this->htmlAttributes);

        return $this->renderPrepend()."<a {$attributes}>{$this->text}</a>".$this->renderAppend();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
