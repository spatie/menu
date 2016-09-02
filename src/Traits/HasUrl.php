<?php

namespace Spatie\Menu\Traits;

/**
 * Expects a `$url` and a `$prefixes` property on the class.
 *
 * @property string $url
 * @property array $prefixes
 */
trait HasUrl
{
    /**
     * @return string
     */
    public function getUrl(): string
    {
        if (empty($this->prefixes)) {
            return $this->url;
        }

        return implode('', $this->prefixes).'/'.ltrim($this->url, '/');
    }

    /**
     * Return a segment of the link's URL. This function works for both absolute
     * and relative URL's. The index is a 1-index based number. Trailing and
     * double slashes are ignored.
     *
     * Example: (new Link('Open Source', 'https://spatie.be/opensource'))->segment(1)
     *      => 'opensource'
     *
     * @param int $index
     *
     * @return string|null
     */
    public function segment(int $index)
    {
        $path = parse_url($this->url)['path'] ?? '';

        $segments = array_values(
            array_filter(
                explode('/', $path),
                function ($value) {
                    return $value !== '';
                }
            )
        );

        return $segments[$index - 1] ?? null;
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
}
