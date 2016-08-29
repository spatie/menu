<?php

namespace Spatie\Menu\Traits;

use Spatie\HtmlElement\Attributes;

trait HtmlAttributes
{
    /** @var \Spatie\HtmlElement\Attributes */
    protected $htmlAttributes;

    protected function initializeHtmlAttributes()
    {
        $this->htmlAttributes = new Attributes();
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setAttribute(string $attribute, string $value = '')
    {
        $this->htmlAttributes->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->htmlAttributes->setAttributes($attributes);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class)
    {
        $this->htmlAttributes->addClass($class);

        return $this;
    }
}
