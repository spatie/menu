<?php

namespace Spatie\Menu;

use InvalidArgumentException;

class Url
{
    /** @var string */
    protected $url;

    public function __construct(string $url)
    {
        $this->url = rtrim($url, '/');
    }

    public function url(): string
    {
        return $this->url;
    }

    public function host(): string
    {
        return $this->parse()['host'] ?? '';
    }

    public function hasHost(): bool
    {
        return ! empty($this->host());
    }

    public function isRelative(): bool
    {
        return ! $this->hasHost() && strpos($this->path(), '/') !== 0;
    }

    public function path(): string
    {
        return $this->parse()['path'] ?? '';
    }

    protected function parse(): array
    {
        return parse_url($this->url);
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
            $url = new static($url);
        }

        if (! $url instanceof static) {
            throw new InvalidArgumentException("`$url` must be a string or an instance of Spatie\\Menu\\HelpersUrl");
        }

        return $this->host() === $url->host() && $this->path() === $url->path();
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
                explode('/', $this->path()),
                function ($value) {
                    return $value !== '';
                }
            )
        );

        return $segments[$index - 1] ?? null;
    }

    public function prefix(string $prefix)
    {
        if (! $this->hasHost() && $this->isRelative()) {
            $this->url = rtrim($prefix, '/') . '/' . $this->url;
        }
    }
}
