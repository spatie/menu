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

    public function setParentAttribute(string $attribute, string $value = ''): static;

    public function setParentAttributes(array $attributes): static;

    public function addParentClass(string $class): static;

    public function parentId(?string $id): static;
}
