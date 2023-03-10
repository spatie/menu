<?php

namespace Spatie\Menu\Traits;

/**
 * Expects a `$htmlAttributes` property on the class.
 *
 * @property $htmlAttributes \Spatie\Menu\Html\Attributes
 */
trait HasHtmlAttributes
{
    public function setAttribute(string $attribute, string $value = ''): static
    {
        $this->htmlAttributes->setAttribute($attribute, $value);

        return $this;
    }

    public function setAttributes(array $attributes): static
    {
        $this->htmlAttributes->setAttributes($attributes);

        return $this;
    }

    public function addClass(string $class): static
    {
        $this->htmlAttributes->addClass($class);

        return $this;
    }

    public function id(?string $id): static
    {
        $this->htmlAttributes->id($id);

        return $this;
    }
}
