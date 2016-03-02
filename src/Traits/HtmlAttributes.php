<?php

namespace Spatie\Menu\Traits;

trait HtmlAttributes
{
    /** @var \Spatie\Menu\Helpers\HtmlAttributes */
    protected $attributes;

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return static
     */
    public function setAttribute(string $attribute, string $value = '')
    {
        $this->attributes->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class)
    {
        $this->attributes->addClass($class);

        return $this;
    }
}
