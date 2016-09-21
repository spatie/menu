<?php

namespace Spatie\Menu;

interface HasUrl
{
    /**
     * @return string
     */
    public function url(): string;

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url);

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix);
}
