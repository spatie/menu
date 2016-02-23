<?php

namespace Spatie\Menu\Traits;

trait HtmlElement
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return string
     */
    abstract protected function element() : string;

    /**
     * @return array
     */
    public function attributes() : array
    {
        return $this->attributes;
    }

    /**
     * @param string $attribute
     * @param null $value
     *
     * @return static
     */
    public function addAttribute(string $attribute, $value = null)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * @param array $overrides
     *
     * @return string
     */
    protected function renderAttributes(array $overrides = []) : string
    {
        $attributes = array_merge($this->attributes, $overrides);

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

    /**
     * @param string $innerHtml
     * @param array $overrides
     *
     * @return string
     */
    public function renderHtml(string $innerHtml = '', array $overrides = [])
    {
        $attributes = $this->renderAttributes($overrides);

        $openingTag = !empty($attributes) ? "<{$this->element()} {$attributes}>" : "<{$this->element()}>";
        $closingTag = "</{$this->element()}>";

        return "{$openingTag}{$innerHtml}{$closingTag}";
    }
}
