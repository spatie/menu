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
     *
     * @return $this
     */
    public function determineActiveForUrl(string $url);
}
