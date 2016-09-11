<?php

namespace Spatie\Menu\Traits;

use Spatie\Menu\Url;

/**
 * Expects a `$url` and a `$prefixes` property on the class.
 *
 * @property string $url
 * @property array $prefixes
 */
trait HasUrl
{
    /**
     * @return \Spatie\Menu\Url
     */
    public function getUrl(): Url
    {
        if (empty($this->prefixes)) {
            return Url::create($this->url);
        }

        return Url::create(implode('', $this->prefixes).'/'.ltrim($this->url, '/'));
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix)
    {
        $this->prefixes[] = $prefix;

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
