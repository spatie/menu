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
    public function getParentAttributes(): array;

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setParentAttribute(string $attribute, string $value = '');

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addParentClass(string $class);
}
