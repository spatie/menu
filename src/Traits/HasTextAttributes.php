<?php

namespace Spatie\Menu\Traits;

trait HasTextAttributes
{
    /**
     * Prepend the anchor with a string of html on render.
     *
     * @param string $prepend
     *
     * @return $this
     */
    public function prepend(string $prepend)
    {
        $this->prepend = $prepend;

        return $this;
    }

    /**
     * Prepend the text with a string of html on render if a certain condition is
     * met.
     *
     * @param bool $condition
     * @param string $prepend
     *
     * @return $this
     */
    public function prependIf($condition, string $prepend)
    {
        if ($this->resolveCondition($condition)) {
            return $this->prepend($prepend);
        }

        return $this;
    }

    /**
     * Append a text of html to the menu on render.
     *
     * @param string $append
     *
     * @return $this
     */
    public function append(string $append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Append the text with a string of html on render if a certain condition is
     * met.
     *
     * @param bool $condition
     * @param string $append
     *
     * @return static
     */
    public function appendIf($condition, string $append)
    {
        if ($this->resolveCondition($condition)) {
            return $this->append($append);
        }

        return $this;
    }
}
