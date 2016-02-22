<?php

namespace Spatie\Menu\Traits;

trait HtmlElement
{
    /** @var array */
    protected $attributes = [];

    /** @var array */
    protected $classNames = [];

    public function attributes() : array
    {
        return $this->attributes;
    }

    public function classNames() : array
    {
        return $this->classNames;
    }

    /** @return static */
    public function addClass(string $className)
    {
        $this->classNames[] = $className;

        return $this;
    }

    /** @return static */
    public function addAttribute(string $attribute, $value = null)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    public function renderHtml(string $element, string $innerHtml = '', array $extraClassNames = [])
    {
        $attributes = $this->renderAttributes($extraClassNames);

        $openingTag = !empty($attributes) ? "<{$element} {$attributes}>" : "<{$element}>";
        $closingTag = "</{$element}>";

        return "{$openingTag}{$innerHtml}{$closingTag}";
    }

    protected function renderAttributes(array $extraClassNames = []) : string
    {
        $attributes = $this->attributes;
        $classNames = array_merge($this->classNames, $extraClassNames);

        if (! empty($classNames)) {
            $attributes['class'] = implode(' ', $classNames);
        }

        if (! count($attributes)) {
            return '';
        }

        $attributeStrings = [];

        foreach ($attributes as $attribute => $value) {
            if (empty($value)) {
                $attributeStrings[] = $attribute;
                continue;
            }

            $attributeStrings[] = "{$attribute}=\"{$value}\"";
        }

        return implode(' ', $attributeStrings);
    }
}
