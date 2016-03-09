<?php

namespace Spatie\Menu\Traits;

use Spatie\HtmlElement\Attributes;

trait ParentAttributes
{
    /** @var \Spatie\HtmlElement\Attributes */
    private $parentAttributes;

    protected function parentAttributes() : Attributes
    {
        if ($this->parentAttributes === null) {
            $this->parentAttributes = new Attributes();
        }

        return $this->parentAttributes;
    }

    public function getParentAttributes() : array
    {
        return $this->parentAttributes()->toArray();
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return static
     */
    public function setParentAttribute(string $attribute, string $value = '')
    {
        $this->parentAttributes()->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addParentClass(string $class)
    {
        $this->parentAttributes()->addClass($class);

        return $this;
    }
}
