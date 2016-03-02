<?php

namespace Spatie\Menu\Helpers;

class HtmlAttributes
{
    /** @var array */
    protected $attributes = [];

    /** @var array */
    protected $classes = [];

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return static
     * @throws \Exception
     */
    public function setAttribute(string $attribute, string $value = '')
    {
        if ($attribute === 'class') {
            $this->classes = explode(' ', $value);
            return $this;
        }

        $this->attributes['attribute'] = $value;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function addClass(string $class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge($this->attributes, ['class' => implode(' ',$this->classes)]);
    }
}
