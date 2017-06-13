<?php

namespace Spatie\Menu\Traits;

/**
 * Expects a `$parentAttributes` propert on the class.
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

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setParentAttribute(string $attribute, string $value = '')
    {
        $this->parentAttributes->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setParentAttributes(array $attributes)
    {
        $this->parentAttributes->setAttributes($attributes);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addParentClass(string $class)
    {
        $this->parentAttributes->addClass($class);

        return $this;
    }
}
