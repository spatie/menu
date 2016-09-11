<?php

namespace Spatie\Menu;

interface HasUrl
{
    /**
     * @return \Spatie\Menu\Url
     */
    public function getUrl(): Url;

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix);
}
