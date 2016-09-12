<?php

namespace Spatie\Menu\Traits;

use Spatie\Menu\Url;

/**
 * Expects a `$url` and a `$prefixes` property on the class.
 *
 * @property \Spatie\Menu\Url $url
 * @property array $prefixes
 */
trait HasUrl
{
    /**
     * @return \Spatie\Menu\Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix)
    {
        $this->url->prefix($prefix);

        return $this;
    }

    /**
     * @param string $url
     */
    public function determineActiveForUrl(string $url)
    {
        // TODO: Implement determineActiveForUrl() method.
    }
}
