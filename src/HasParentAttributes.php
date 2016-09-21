<?php

namespace Spatie\Menu;

interface HasParentAttributes
{
    /**
     * Return an array of attributes to apply on the parent. This generally means
     * the attributes that should be applied on the <li> tag.
     *
     * @return array
     */
    public function parentAttributes(): array;

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setParentAttribute(string $attribute, string $value = '');

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setParentAttributes(array $attributes);

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addParentClass(string $class);
}
