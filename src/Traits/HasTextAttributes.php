<?php

namespace Spatie\Menu\Traits;

use Spatie\Menu\Item;

trait HasTextAttributes
{
    /**
     * Prepend the anchor with a string of html on render.
     *
     * @param string|Item $prepend
     *
     * @return $this
     */
    public function prepend($prepend)
    {
        $this->prepend = $prepend;

        return $this;
    }

    /**
     * Prepend the text with a string of html on render if a certain condition is
     * met.
     *
     * @param mixed $condition
     * @param string|Item $prepend
     *
     * @return $this
     */
    public function prependIf($condition, $prepend)
    {
        if ($this->resolveCondition($condition)) {
            return $this->prepend($prepend);
        }

        return $this;
    }

    /**
     * Append a text of html to the menu on render.
     *
     * @param string|Item $append
     *
     * @return $this
     */
    public function append($append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Append the text with a string of html on render if a certain condition is
     * met.
     *
     * @param bool $condition
     * @param string|Item $append
     *
     * @return static
     */
    public function appendIf($condition, $append)
    {
        if ($this->resolveCondition($condition)) {
            return $this->append($append);
        }

        return $this;
    }

    protected function renderPrepend()
    {
        return $this->prepend instanceof Item
            ? $this->prepend->render()
            : $this->prepend;
    }

    protected function renderAppend()
    {
        return $this->append instanceof Item
            ? $this->append->render()
            : $this->append;
    }
}
