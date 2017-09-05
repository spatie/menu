<?php

namespace Spatie\Menu\Traits;

use Spatie\Url\Url;
use Spatie\Menu\ActiveUrlChecker;

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
     * @return string|null
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function hasUrl(): bool
    {
        return ! is_null($this->url);
    }

    /**
     * @param string|null $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string $url
     * @param string $root
     *
     * @return $this
     */
    public function determineActiveForUrl(string $url, string $root = '/')
    {
        if (! $this->hasUrl()) {
            return;
        }

        ActiveUrlChecker::check($this->url, $url, $root)
            ? $this->setActive()
            : $this->setInactive();
    }
}
