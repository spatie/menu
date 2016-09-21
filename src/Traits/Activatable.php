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
     * @return $this
     */
    public function setActive()
    {
        $this->active = true;

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
