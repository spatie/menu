<?php

namespace Spatie\Menu;

interface HasUrl extends Activatable
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
}
