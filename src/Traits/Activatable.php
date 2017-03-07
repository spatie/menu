<?php

namespace Spatie\Menu\Traits;

use Spatie\Url\Url;
use Spatie\Menu\Helpers\Str;

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

        $itemUrl = Url::fromString($this->url);
        $matchUrl = Url::fromString($url);

        // If the hosts don't match, this url isn't active.
        if ($itemUrl->getHost() !== $matchUrl->getHost()) {
            return $this->setInactive();
        }

        $root = Str::ensureLeft('/', $root);

        // All paths used in this method should be terminated by a /
        // otherwise startsWith at the end will be too greedy and
        // also matches items which are on the same level
        $root = Str::ensureRight('/', $root);

        $itemPath = Str::ensureRight('/', $itemUrl->getPath());

        // If this url doesn't start with the root, it's inactive.
        if (! Str::startsWith($itemPath, $root)) {
            return $this->setInactive();
        }

        $matchPath = Str::ensureRight('/', $matchUrl->getPath());

        // For the next comparisons we just need the paths, and we'll remove
        // the root first.
        $itemPath = Str::removeFromStart($root, $itemPath);
        $matchPath = Str::removeFromStart($root, $matchPath);

        // If this url starts with the url we're matching with, it's active.
        if ($matchPath === $itemPath || Str::startsWith($matchPath, $itemPath)) {
            return $this->setActive();
        }

        return $this->setInactive();
    }
}
