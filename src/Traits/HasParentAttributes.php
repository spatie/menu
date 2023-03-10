<?php

namespace Spatie\Menu\Traits;

/**
 * Expects a `$parentAttributes` property on the class.
 *
 * @property $parentAttributes \Spatie\Menu\Html\Attributes
 */
trait HasParentAttributes
{
    /**
     * Return an array of attributes to apply on the parent. This generally means
     * the attributes that should be applied on the <li> tag.
     *
     * @return array
     */
    public function parentAttributes(): array
    {
        return $this->parentAttributes->toArray();
    }

    public function setParentAttribute(string $attribute, string $value = ''): static
    {
        $this->parentAttributes->setAttribute($attribute, $value);

        return $this;
    }

    public function setParentAttributes(array $attributes): static
    {
        $this->parentAttributes->setAttributes($attributes);

        return $this;
    }

    public function addParentClass(string $class): static
    {
        $this->parentAttributes->addClass($class);

        return $this;
    }

    public function parentId(?string $id): static
    {
        $this->parentAttributes->id($id);

        return $this;
    }
}
