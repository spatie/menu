<?php

namespace Spatie\Menu\Traits;

use Spatie\HtmlElement\Attributes;

trait ParentAttributes
{
    /** @var \Spatie\HtmlElement\Attributes */
    protected $parentAttributes;

    protected function bootParentAttributes()
    {
        $this->parentAttributes = new Attributes();
    }

    /**
     * Return an array of attributes to apply on the parent. This generally means the attributes
     * that should be applied on the <li> tag.
     *
     * @return array
     */
    public function getParentAttributes() : array
    {
        return $this->parentAttributes->toArray();
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setParentAttribute(string $attribute, string $value = '')
    {
        $this->parentAttributes->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addParentClass(string $class)
    {
        $this->parentAttributes->addClass($class);

        return $this;
    }
}
