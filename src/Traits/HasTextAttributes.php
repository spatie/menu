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
    public function prepend(string | Item $prepend): self
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
    public function prependIf(mixed $condition, string | Item $prepend): self
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
    public function append(string | Item $append): self
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Append the text with a string of html on render if a certain condition is
     * met.
     *
     * @param bool|callable $condition
     * @param string|Item $append
     *
     * @return $this
     */
    public function appendIf(bool | callable $condition, string | Item $append): self
    {
        if ($this->resolveCondition($condition)) {
            return $this->append($append);
        }

        return $this;
    }

    protected function renderPrepend(): string
    {
        return $this->prepend instanceof Item
            ? $this->prepend->render()
            : $this->prepend;
    }

    protected function renderAppend(): string
    {
        return $this->append instanceof Item
            ? $this->append->render()
            : $this->append;
    }
}
