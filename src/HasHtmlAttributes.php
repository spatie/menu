<?php

namespace Spatie\Menu;

interface HasHtmlAttributes
{
    public function setAttribute(string $attribute, string $value = ''): static;

    public function setAttributes(array $attributes): static;

    public function addClass(string $class): static;

    public function id(?string $id): static;
}
