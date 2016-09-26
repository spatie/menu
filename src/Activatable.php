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
     * @param string $url
     * @param string $root
     */
    public function determineActiveForUrl(string $url, string $root = '/');
}
