<?php

namespace Spatie\Menu\Traits;

/**
 * Expects an `$active` property on the class.
 *
 * @property string $url
 */
trait Activatable
{
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool|callable $active
     *
     * @return $this
     */
    public function setActive($active = true)
    {
        if (is_callable($active)) {
            $this->active = $active($this);

            return $this;
        }

        $this->active = (bool) $active;

        return $this;
    }

    /**
     * @return $this
     */
    public function setInactive()
    {
        $this->active = false;

        return $this;
    }

    /**
     * @param string $url
     * @param string $root
     */
    public function determineActiveForUrl(string $url, string $root = '')
    {
    }
}
