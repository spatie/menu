<?php

namespace Spatie\Menu\Traits;

use Spatie\HtmlElement\Attributes;

trait HtmlAttributes
{
    /** @var \Spatie\HtmlElement\Attributes */
    private $htmlAttributes;

    /**
     * @return \Spatie\HtmlElement\Attributes
     */
    protected function attributes() : Attributes
    {
        if ($this->htmlAttributes === null) {
            $this->htmlAttributes = new Attributes();
        }

        return $this->htmlAttributes;
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setAttribute(string $attribute, string $value = '')
    {
        $this->attributes()->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class)
    {
        $this->attributes()->addClass($class);

        return $this;
    }
}
