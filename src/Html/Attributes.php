<?php

namespace Spatie\Menu\Html;

class Attributes
{
    protected array $attributes = [];

    protected array $classes = [];

    protected ?string $id = null;

    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $attribute => $value) {
            if ($attribute === 'class') {
                $this->addClass($value);

                continue;
            }

            if (is_int($attribute)) {
                $attribute = $value;
                $value = '';
            }

            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    public function setAttribute(string $attribute, string $value = ''): self
    {
        if ($attribute === 'class') {
            $this->addClass($value);

            return $this;
        }

        $this->attributes[$attribute] = $value;

        return $this;
    }

    public function addClass(string | array $class): self
    {
        if (! is_array($class)) {
            $class = [$class];
        }

        $this->classes = array_unique(
            array_merge($this->classes, $class)
        );

        return $this;
    }

    public function id(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function mergeWith(self $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes->attributes);
        $this->classes = array_merge($this->classes, $attributes->classes);
        $this->id = $this->id ?: $attributes->id;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    public function toArray(): array
    {
        return array_merge($this->attributes, array_filter([
            'class' => implode(' ', $this->classes),
            'id' => $this->id,
        ]));
    }

    public function toString(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        $attributeStrings = [];

        foreach ($this->toArray() as $attribute => $value) {
            if (is_null($value) || $value === '') {
                $attributeStrings[] = $attribute;

                continue;
            }

            $attributeStrings[] = "{$attribute}=\"{$value}\"";
        }

        return implode(' ', $attributeStrings);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
