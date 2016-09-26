<?php

namespace Spatie\Menu\Traits;

use Spatie\Menu\Helpers\Str;
use Spatie\Url\Url;

/**
 * Expects a `$url` property on the class.
 *
 * @property string $url
 */
trait HasUrl
{
    use Activatable;

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url)
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
        $itemUrl = Url::fromString($this->url);
        $matchUrl = Url::fromString($url);

        // If the hosts don't match, this url isn't active.
        if ($itemUrl->getHost() !== $matchUrl->getHost()) {
            return $this->setInactive();
        }

        // If this url doesn't start with the root, it's inactive.
        if (! Str::startsWith($itemUrl->getPath(), $root)) {
            return $this->setInactive();
        }

        // For the next comparisons we just need the paths, and we'll remove
        // the root first.
        $itemPath = Str::removeFromStart($root, $itemUrl->getPath());
        $matchPath = Str::removeFromStart($root, $matchUrl->getPath());

        // If this url starts with the url we're matching with, it's active.
        if (Str::startsWith($matchPath, $itemPath)) {
            return $this->setActive();
        }

        return $this->setInactive();
    }
}
