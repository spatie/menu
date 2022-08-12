<?php

namespace Spatie\Menu\Html;

class Attributes
{
    /**
     * Array of attributes.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Array of classes.
     *
     * @var array
     */
    protected array $classes = [];

    /**
     * magic method.
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set attributes by array of attribute.
     *
     * @param  array $attributes
     * @return $this
     */
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


    /**
     * Set attribute by array of attribute & value.
     *
     * @param  string $attribute
     * @param  string $value
     * @return $this
     */
    public function setAttribute(string $attribute, string $value = ''): self
    {
        if ($attribute === 'class') {
            $this->addClass($value);

            return $this;
        }

        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Add class.
     *
     * @param  string|array $class
     * @return $this
     */
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

    /**
     * Merge with attributes.
     *
     * @param  Attributes $attributes
     * @return $this
     */
    public function mergeWith(self $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes->attributes);
        $this->classes = array_merge($this->classes, $attributes->classes);

        return $this;
    }

    /**
     * Check is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    /**
     * To array attributes.
     *
     * @return array
     */
    public function toArray(): array
    {
        if (empty($this->classes)) {
            return $this->attributes;
        }

        return array_merge($this->attributes, ['class' => implode(' ', $this->classes)]);
    }

    /**
     * To string attributes.
     *
     * @return string
     */
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

    /**
     * Use magic method for to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
