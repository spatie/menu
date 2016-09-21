<?php

namespace Spatie\Menu;

interface Activatable
{
    /**
     * @return $this
     */
    public function setActive();

    /**
     * @return $this
     */
    public function setInactive();

    /**
     * @param string $url
     * @param string $root
     */
    public function determineActiveForUrl(string $url, string $root = '/');
}
