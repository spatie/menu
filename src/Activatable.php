<?php

namespace Spatie\Menu;

interface Activatable
{
    /**
     * @param bool|callable $active
     *
     * @return $this
     */
    public function setActive($active = true);

    /**
     * @return $this
     */
    public function setInactive();

    /**
     * @return string|null
     */
    public function url();

    /**
     * @return bool
     */
    public function hasUrl(): bool;

    /**
     * @param string|null $url
     *
     * @return $this
     */
    public function setUrl($url);

    /**
     * @param string $url
     * @param string $root
     */
    public function determineActiveForUrl(string $url, string $root = '/');
}
