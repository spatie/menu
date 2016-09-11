<?php

namespace Spatie\Menu;

use InvalidArgumentException;

class Url
{
    /** @var string */
    protected $host;

    /** @var string */
    protected $path;

    protected function __construct(string $host, string $path)
    {
        $this->host = $host;
        $this->path = $path;
    }

    /**
     * @param string $url
     *
     * @return \Spatie\Menu\Url
     */
    public static function create(string $url)
    {
        $url = parse_url(rtrim($url, '/'));

        return new static($url['host'] ?? '', $url['path'] ?? '');
    }

    /**
     * Check if a Url (string or Url instance) mathes (same host and path) this instance.
     *
     * @param string|\Spatie\Menu\Url $url
     *
     * @return bool
     */
    public function matches($url): bool
    {
        if (is_string($url)) {
            $url = static::create($url);
        }

        if (! $url instanceof static) {
            throw new InvalidArgumentException("`$url` must be a string or an instance of Spatie\\Menu\\HelpersUrl");
        }

        return $this->host === $url->host && $this->path === $url->path;
    }

    /**
     * Return a segment of a Url. The index is a 1-index based number. Returns null if the segment doesn't exist.
     *
     * Example: Url::create('https://spatie.be/opensource/laravel-menu')->segment(1) => 'opensource'
     *
     * @param int $index
     *
     * @return string|null
     */
    public function segment(int $index)
    {
        $segments = array_values(
            array_filter(
                explode('/', $this->path),
                function ($value) {
                    return $value !== '';
                }
            )
        );

        return $segments[$index - 1] ?? null;
    }
}
